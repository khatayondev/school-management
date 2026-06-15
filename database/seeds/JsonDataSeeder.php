<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\UserRole;
use App\IClass;
use App\Section;
use App\Subject;
use App\Employee;
use App\Student;
use App\Registration;
use App\Exam;
use App\Mark;
use App\StudentAttendance;
use App\StudentLedger;
use App\AcademicYear;
use App\Http\Helpers\AppHelper;

class JsonDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo 'Seeding database from dummy_db.json...', PHP_EOL;

        // Load JSON data
        $jsonPath = database_path('dummy_db.json');
        if (!file_exists($jsonPath)) {
            echo 'Error: dummy_db.json not found in database path.', PHP_EOL;
            return;
        }

        $rawData = file_get_contents($jsonPath);
        $data = json_decode($rawData, true);

        if (!$data) {
            echo 'Error: Failed to decode JSON from dummy_db.json.', PHP_EOL;
            return;
        }

        // Disable foreign keys
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("PRAGMA foreign_keys=OFF");
        } else {
            DB::statement("SET foreign_key_checks=0");
        }

        // Clear tables
        echo 'Truncating existing data tables...', PHP_EOL;
        DB::table('users_permissions')->delete();
        UserRole::truncate();
        User::where('id', '>', 2)->delete(); // Keep main admin/accountant or truncate all and recreate
        User::truncate(); 
        IClass::truncate();
        Section::truncate();
        Subject::truncate();
        Employee::truncate();
        Student::truncate();
        Registration::truncate();
        Exam::truncate();
        Mark::truncate();
        StudentAttendance::truncate();
        StudentLedger::truncate();
        DB::table('teacher_subjects')->truncate();
        DB::table('student_subjects')->truncate();
        DB::table('exam_iclass')->truncate();
        \App\AcademicTerm::truncate();
        \App\FeeType::truncate();
        \App\ExpenseCategory::truncate();

        // 1. Ensure Academic Year 1 exists
        echo 'Setting up academic year and term...', PHP_EOL;
        AcademicYear::truncate();
        $acYear = AcademicYear::create([
            'id' => 1,
            'title' => date('Y'),
            'start_date' => Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y')),
            'end_date' => Carbon::createFromFormat('d/m/Y', '31/12/'.date('Y')),
            'status' => '1',
        ]);

        \App\AcademicTerm::create([
            'id' => 1,
            'academic_year_id' => 1,
            'name' => 'First Term',
            'start_date' => Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y')),
            'end_date' => Carbon::createFromFormat('d/m/Y', '30/06/'.date('Y')),
            'status' => '1',
        ]);

        // Seed Fee Types and Expense Categories
        echo 'Seeding finance types and categories...', PHP_EOL;
        $financeSeeder = new FinanceDataSeeder();
        $financeSeeder->run();

        // 2. Insert Users and UserRoles
        echo 'Inserting users...', PHP_EOL;
        foreach ($data['users'] as $u) {
            $user = User::create([
                'id' => $u['id'],
                'name' => $u['name'],
                'username' => $u['username'],
                'email' => $u['email'],
                'password' => bcrypt('123456'), // Default password for everyone
                'remember_token' => null,
                'status' => 1,
            ]);

            // Assign User Role
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $u['role_id'],
            ]);
        }

        // 3. Insert Classes
        echo 'Inserting classes...', PHP_EOL;
        foreach ($data['classes'] as $c) {
            IClass::create([
                'id' => $c['id'],
                'name' => $c['name'],
                'numeric_value' => $c['numeric'],
                'order' => $c['numeric'],
                'group' => 'None',
                'status' => '1',
                'note' => $c['name'] . ' Class',
            ]);
        }

        // 4. Insert Employees (Teachers/Staff)
        echo 'Inserting employees...', PHP_EOL;
        foreach ($data['employees'] as $emp) {
            $desg = 20; // other
            if (strpos($emp['designation'], 'Lecturer') !== false) {
                $desg = 6;
            } elseif (strpos($emp['designation'], 'Accountant') !== false || strpos($emp['designation'], 'Finance') !== false) {
                $desg = 15;
            } elseif (strpos($emp['designation'], 'Headmaster') !== false || strpos($emp['designation'], 'Head Teacher') !== false) {
                $desg = 7;
            } elseif (strpos($emp['designation'], 'Professor') !== false) {
                $desg = 3;
            }

            Employee::create([
                'id' => $emp['id'],
                'user_id' => $emp['user_id'],
                'role_id' => $emp['id'] === 1 ? 4 : 2, // Francisco (ID 1) is Accountant (4), others are Teachers (2)
                'id_card' => 'EMP-' . sprintf('%03d', $emp['id']),
                'name' => $emp['name'],
                'designation' => $desg,
                'dob' => '01/01/1985',
                'gender' => 1,
                'religion' => 2, // Christian
                'phone_no' => $emp['phone'],
                'joining_date' => Carbon::parse($emp['joining_date'])->format('d/m/Y'),
                'status' => '1',
            ]);
        }

        // 5. Insert Sections
        echo 'Inserting sections...', PHP_EOL;
        foreach ($data['sections'] as $s) {
            Section::create([
                'id' => $s['id'],
                'class_id' => $s['class_id'],
                'name' => $s['name'],
                'capacity' => 50,
                'teacher_id' => 1,
                'status' => '1',
            ]);
        }

        // 6. Insert Subjects
        echo 'Inserting subjects...', PHP_EOL;
        foreach ($data['subjects'] as $sub) {
            Subject::create([
                'id' => $sub['id'],
                'name' => $sub['name'],
                'code' => $sub['code'],
                'type' => $sub['type'] === 'practical' ? 2 : 1, // mapping custom types if needed
                'status' => '1',
            ]);
        }

        // 7. Insert Students and Registrations
        echo 'Inserting students and registrations...', PHP_EOL;
        foreach ($data['students'] as $st) {
            Student::create([
                'id' => $st['id'],
                'user_id' => $st['user_id'],
                'name' => $st['name'],
                'dob' => '01/01/2015',
                'phone_no' => $st['phone'],
                'permanent_address' => 'Ho, Ghana',
                'status' => '1',
            ]);

            // Register Student for academic year 1
            Registration::create([
                'id' => $st['id'],
                'regi_no' => $st['reg_no'],
                'student_id' => $st['id'],
                'class_id' => $st['class_id'],
                'section_id' => $st['section_id'],
                'academic_year_id' => 1,
                'roll_no' => $st['roll_no'],
                'shift' => '1',
                'status' => '1',
            ]);
        }

        // 8. Insert Exams
        echo 'Inserting exams...', PHP_EOL;
        foreach ($data['exams'] as $ex) {
            $exam = Exam::create([
                'id' => $ex['id'],
                'name' => $ex['name'],
                'ca_weight' => 30,
                'status' => $ex['status'] === 'completed' ? 1 : 0,
                'open_for_marks_entry' => 1,
            ]);

            // Associate exam with all classes (Grade 1 to 5)
            foreach ($data['classes'] as $c) {
                DB::table('exam_iclass')->insert([
                    'exam_id' => $exam->id,
                    'class_id' => $c['id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 9. Insert Marks
        echo 'Inserting marks...', PHP_EOL;
        foreach ($data['marks'] as $m) {
            $student = null;
            // find student to get class/section
            foreach ($data['students'] as $st) {
                if ($st['id'] == $m['student_id']) {
                    $student = $st;
                    break;
                }
            }

            if ($student) {
                Mark::create([
                    'id' => $m['id'],
                    'academic_year_id' => 1,
                    'class_id' => $student['class_id'],
                    'section_id' => $student['section_id'],
                    'registration_id' => $student['id'], // student_id acts as registration_id here
                    'exam_id' => $m['exam_id'],
                    'subject_id' => $m['subject_id'],
                    'ca_marks' => $m['class_work_score'],
                    'exam_marks' => $m['exam_score'],
                    'total_marks' => $m['total_score'],
                    'grade' => $m['grade'],
                    'present' => 1,
                ]);
            }
        }

        // 10. Insert Attendances
        echo 'Inserting student attendances...', PHP_EOL;
        foreach ($data['attendances'] as $att) {
            $student = null;
            foreach ($data['students'] as $st) {
                if ($st['id'] == $att['student_id']) {
                    $student = $st;
                    break;
                }
            }

            if ($student) {
                // Parsing attendance date, in_time, and out_time correctly
                $attDate = Carbon::parse($att['date']);
                $inTime = Carbon::parse($att['date'] . ' 08:00:00');
                $outTime = Carbon::parse($att['date'] . ' 14:30:00');
                
                StudentAttendance::create([
                    'id' => $att['id'],
                    'academic_year_id' => 1,
                    'class_id' => $student['class_id'],
                    'registration_id' => $student['id'], // student_id acts as registration_id
                    'attendance_date' => $attDate->format('d/m/Y'), // mutator expects d/m/Y format
                    'in_time' => $inTime,
                    'out_time' => $outTime,
                    'staying_hour' => '06:30:00', // Time format (H:i:s)
                    'status' => '1',
                    'present' => $att['status'] === 'present' ? 1 : 0,
                ]);
            }
        }

        // 11. Insert Finance Ledgers (Invoices)
        echo 'Inserting finance ledger...', PHP_EOL;
        foreach ($data['finance_ledger'] as $fl) {
            StudentLedger::create([
                'id' => $fl['id'],
                'registration_id' => $fl['student_id'], // registration id maps to student id
                'student_id' => $fl['student_id'],
                'academic_year_id' => 1,
                'fee_type_id' => strpos($fl['description'], 'Tuition') !== false ? 1 : 2,
                'term_id' => 1,
                'billing_date' => Carbon::parse($fl['date']),
                'description' => $fl['description'],
                'amount' => $fl['amount_due'],
                'amount_paid' => $fl['amount_paid'],
                'balance' => $fl['balance'],
                'source' => 'auto',
                'status' => $fl['payment_status'] === 'paid' ? '1' : '0',
            ]);
        }

        // Enable foreign keys
        if (DB::getDriverName() === 'sqlite') {
            DB::statement("PRAGMA foreign_keys=ON");
        } else {
            DB::statement("SET foreign_key_checks=1");
        }

        // Clear settings cache to force reload
        \Illuminate\Support\Facades\Cache::flush();

        echo 'Database seeding completed successfully!', PHP_EOL;
    }
}
