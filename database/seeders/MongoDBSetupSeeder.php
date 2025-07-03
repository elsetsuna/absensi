<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MongoDB\Client;
use MongoDB\Database;

class MongoDBSetupSeeder extends Seeder
{
    private Database $database;

    public function __construct()
    {
        $client = new Client(config('database.connections.mongodb.dsn'));
        $this->database = $client->selectDatabase(config('database.connections.mongodb.database'));
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUsersCollection();
        $this->createAttendancesCollection();
        $this->createBreakRecordsCollection();
        $this->createIndexes();
        
        $this->command->info('MongoDB collections and indexes created successfully!');
    }

    /**
     * Create users collection with validation
     */
    private function createUsersCollection(): void
    {
        // Drop collection if exists (for fresh setup)
        try {
            $this->database->dropCollection('users');
        } catch (\Exception $e) {
            // Collection might not exist, that's fine
        }

        // Create collection with validation schema
        $this->database->createCollection('users', [
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['username', 'email', 'password'],
                    'properties' => [
                        'username' => [
                            'bsonType' => 'string',
                            'description' => 'Username must be a string and is required'
                        ],
                        'email' => [
                            'bsonType' => 'string',
                            'pattern' => '^[^\s@]+@[^\s@]+\.[^\s@]+$',
                            'description' => 'Email must be a valid email address'
                        ],
                        'password' => [
                            'bsonType' => 'string',
                            'minLength' => 6,
                            'description' => 'Password must be at least 6 characters'
                        ],
                        'nama_lengkap' => [
                            'bsonType' => 'string',
                            'description' => 'Full name must be a string'
                        ],
                        'telegram' => [
                            'bsonType' => 'string',
                            'description' => 'Telegram username'
                        ],
                        'jenis_kelamin' => [
                            'enum' => ['laki-laki', 'perempuan'],
                            'description' => 'Gender must be either laki-laki or perempuan'
                        ],
                        'agama' => [
                            'enum' => ['islam', 'kristen', 'katolik', 'hindu', 'buddha', 'konghucu', 'lainnya'],
                            'description' => 'Religion must be one of the predefined values'
                        ],
                        'bo_web' => [
                            'enum' => ['web-a', 'web-b', 'web-c', 'bo-main', 'bo-backup'],
                            'description' => 'BO/Web must be one of the predefined values'
                        ],
                        'jabatan' => [
                            'enum' => ['admin', 'cs', 'marketing', 'finance', 'tech-support', 'manager', 'supervisor'],
                            'description' => 'Position must be one of the predefined values'
                        ],
                        'employee_id' => [
                            'bsonType' => 'string',
                            'description' => 'Employee ID'
                        ],
                        'status' => [
                            'enum' => ['active', 'inactive', 'suspended'],
                            'description' => 'Status must be active, inactive, or suspended'
                        ],
                        'tanggal_bergabung' => [
                            'bsonType' => 'date',
                            'description' => 'Join date must be a date'
                        ],
                        'created_at' => [
                            'bsonType' => 'date'
                        ],
                        'updated_at' => [
                            'bsonType' => 'date'
                        ]
                    ]
                ]
            ]
        ]);

        $this->command->info('Users collection created with validation schema');
    }

    /**
     * Create attendances collection with validation
     */
    private function createAttendancesCollection(): void
    {
        // Drop collection if exists
        try {
            $this->database->dropCollection('attendances');
        } catch (\Exception $e) {
            // Collection might not exist, that's fine
        }

        // Create collection with validation schema
        $this->database->createCollection('attendances', [
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'date'],
                    'properties' => [
                        'user_id' => [
                            'bsonType' => 'objectId',
                            'description' => 'User ID must be an ObjectId and is required'
                        ],
                        'date' => [
                            'bsonType' => 'date',
                            'description' => 'Date must be a date and is required'
                        ],
                        'check_in' => [
                            'bsonType' => 'date',
                            'description' => 'Check in time must be a date'
                        ],
                        'check_out' => [
                            'bsonType' => 'date',
                            'description' => 'Check out time must be a date'
                        ],
                        'check_in_location' => [
                            'bsonType' => 'object',
                            'properties' => [
                                'latitude' => ['bsonType' => 'number'],
                                'longitude' => ['bsonType' => 'number'],
                                'address' => ['bsonType' => 'string']
                            ]
                        ],
                        'check_out_location' => [
                            'bsonType' => 'object',
                            'properties' => [
                                'latitude' => ['bsonType' => 'number'],
                                'longitude' => ['bsonType' => 'number'],
                                'address' => ['bsonType' => 'string']
                            ]
                        ],
                        'total_hours' => [
                            'bsonType' => 'number',
                            'minimum' => 0,
                            'description' => 'Total hours must be a positive number'
                        ],
                        'overtime_hours' => [
                            'bsonType' => 'number',
                            'minimum' => 0,
                            'description' => 'Overtime hours must be a positive number'
                        ],
                        'status' => [
                            'enum' => ['present', 'absent', 'late', 'half_day', 'sick', 'leave'],
                            'description' => 'Status must be one of the predefined values'
                        ],
                        'approval_status' => [
                            'enum' => ['pending', 'approved', 'rejected'],
                            'description' => 'Approval status must be pending, approved, or rejected'
                        ],
                        'late_minutes' => [
                            'bsonType' => 'int',
                            'minimum' => 0
                        ],
                        'early_leave_minutes' => [
                            'bsonType' => 'int',
                            'minimum' => 0
                        ],
                        'created_at' => [
                            'bsonType' => 'date'
                        ],
                        'updated_at' => [
                            'bsonType' => 'date'
                        ]
                    ]
                ]
            ]
        ]);

        $this->command->info('Attendances collection created with validation schema');
    }

    /**
     * Create break_records collection with validation
     */
    private function createBreakRecordsCollection(): void
    {
        // Drop collection if exists
        try {
            $this->database->dropCollection('break_records');
        } catch (\Exception $e) {
            // Collection might not exist, that's fine
        }

        // Create collection with validation schema
        $this->database->createCollection('break_records', [
            'validator' => [
                '$jsonSchema' => [
                    'bsonType' => 'object',
                    'required' => ['user_id', 'date', 'break_start'],
                    'properties' => [
                        'user_id' => [
                            'bsonType' => 'objectId',
                            'description' => 'User ID must be an ObjectId and is required'
                        ],
                        'attendance_id' => [
                            'bsonType' => 'objectId',
                            'description' => 'Attendance ID must be an ObjectId'
                        ],
                        'date' => [
                            'bsonType' => 'date',
                            'description' => 'Date must be a date and is required'
                        ],
                        'break_start' => [
                            'bsonType' => 'date',
                            'description' => 'Break start time must be a date and is required'
                        ],
                        'break_end' => [
                            'bsonType' => 'date',
                            'description' => 'Break end time must be a date'
                        ],
                        'break_type' => [
                            'enum' => ['regular', 'lunch', 'coffee', 'prayer', 'personal', 'meeting', 'sick'],
                            'description' => 'Break type must be one of the predefined values'
                        ],
                        'duration_minutes' => [
                            'bsonType' => 'int',
                            'minimum' => 0,
                            'description' => 'Duration must be a positive integer'
                        ],
                        'status' => [
                            'enum' => ['active', 'completed', 'cancelled'],
                            'description' => 'Status must be active, completed, or cancelled'
                        ],
                        'location' => [
                            'bsonType' => 'object',
                            'properties' => [
                                'latitude' => ['bsonType' => 'number'],
                                'longitude' => ['bsonType' => 'number'],
                                'address' => ['bsonType' => 'string']
                            ]
                        ],
                        'reason' => [
                            'bsonType' => 'string',
                            'description' => 'Reason for break'
                        ],
                        'created_at' => [
                            'bsonType' => 'date'
                        ],
                        'updated_at' => [
                            'bsonType' => 'date'
                        ]
                    ]
                ]
            ]
        ]);

        $this->command->info('Break records collection created with validation schema');
    }

    /**
     * Create database indexes for performance
     */
    private function createIndexes(): void
    {
        // Users collection indexes
        $usersCollection = $this->database->selectCollection('users');
        
        try {
            $usersCollection->createIndex(['email' => 1], ['unique' => true]);
            $usersCollection->createIndex(['username' => 1], ['unique' => true]);
            $usersCollection->createIndex(['employee_id' => 1], ['unique' => true]);
            $usersCollection->createIndex(['status' => 1]);
            $usersCollection->createIndex(['jabatan' => 1]);
            $usersCollection->createIndex(['bo_web' => 1]);
        } catch (\Exception $e) {
            $this->command->warn('Some user indexes already exist, skipping...');
        }

        // Attendances collection indexes
        $attendancesCollection = $this->database->selectCollection('attendances');
        
        try {
            $attendancesCollection->createIndex(['user_id' => 1, 'date' => -1], ['unique' => true]);
            $attendancesCollection->createIndex(['date' => -1]);
            $attendancesCollection->createIndex(['status' => 1]);
            $attendancesCollection->createIndex(['approval_status' => 1]);
            $attendancesCollection->createIndex(['check_in' => 1]);
            $attendancesCollection->createIndex(['check_out' => 1]);
        } catch (\Exception $e) {
            $this->command->warn('Some attendance indexes already exist, skipping...');
        }

        // Break records collection indexes
        $breakRecordsCollection = $this->database->selectCollection('break_records');
        
        try {
            $breakRecordsCollection->createIndex(['user_id' => 1, 'date' => -1]);
            $breakRecordsCollection->createIndex(['attendance_id' => 1]);
            $breakRecordsCollection->createIndex(['date' => -1]);
            $breakRecordsCollection->createIndex(['status' => 1]);
            $breakRecordsCollection->createIndex(['break_type' => 1]);
            $breakRecordsCollection->createIndex(['break_start' => 1]);
            $breakRecordsCollection->createIndex(['break_end' => 1]);
        } catch (\Exception $e) {
            $this->command->warn('Some break record indexes already exist, skipping...');
        }

        // Compound indexes for common queries
        try {
            $attendancesCollection->createIndex(['user_id' => 1, 'status' => 1, 'date' => -1]);
            $breakRecordsCollection->createIndex(['user_id' => 1, 'status' => 1, 'date' => -1]);
        } catch (\Exception $e) {
            $this->command->warn('Some compound indexes already exist, skipping...');
        }

        $this->command->info('Database indexes created successfully');
    }
}