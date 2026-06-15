import json
import random
import os

# Sample name lists for realistic generation
first_names = [
    "Kofi", "Ama", "Kwame", "Yaw", "Amina", "Abdul", "Fatima", "Mensah", 
    "Serwaa", "Boateng", "Osei", "Oppong", "Gyamfi", "Agyemang", "Kyei", 
    "Appiah", "Dankwa", "Adu", "Baah", "Frimpong", "Owusu", "Addai", 
    "Tetteh", "Annan", "Quansah", "Ackon", "Larbi", "Mensah", "Abban",
    "John", "Sarah", "David", "Emmanuel", "Grace", "Mary", "Michael", 
    "Daniel", "Elizabeth", "Joseph", "Samuel", "Stephen", "Esther"
]

last_names = [
    "Mensah", "Owusu", "Appiah", "Osei", "Gyasi", "Addo", "Tetteh", "Annan", 
    "Boakye", "Frimpong", "Agyemang", "Appiah", "Asare", "Koomson", "Arthur", 
    "Donkor", "Mensah", "Quaye", "Sowah", "Sackey", "Amponsah", "Adusei",
    "Doe", "Smith", "Johnson", "Williams", "Brown", "Jones", "Garcia", 
    "Miller", "Davis", "Rodriguez", "Martinez", "Hernandez", "Lopez"
]

departments = [
    "Languages & Linguistics", "Mathematics & Statistics", "Natural Sciences", 
    "Information Technology", "Social Sciences", "Creative Arts & Music", "Physical Education"
]

designations = [
    "Head Teacher", "Senior Teacher", "Assistant Teacher", "Tutor", "Special Education Specialist"
]

subjects_pool = [
    {"name": "Mathematics", "code": "MATH"},
    {"name": "English Language", "code": "ENGL"},
    {"name": "Integrated Science", "code": "ISCI"},
    {"name": "Social Studies", "code": "SSTU"},
    {"name": "Information Technology (ICT)", "code": "ICTS"},
    {"name": "French", "code": "FREN"},
    {"name": "Creative Arts", "code": "CART"},
    {"name": "Physical Education", "code": "PHED"}
]

classes_pool = [
    {"name": "Grade 1", "numeric": 1},
    {"name": "Grade 2", "numeric": 2},
    {"name": "Grade 3", "numeric": 3},
    {"name": "Grade 4", "numeric": 4},
    {"name": "Grade 5", "numeric": 5},
    {"name": "Grade 6", "numeric": 6},
    {"name": "JHS 1", "numeric": 7},
    {"name": "JHS 2", "numeric": 8},
    {"name": "JHS 3", "numeric": 9}
]

def generate_data():
    random.seed(42)  # For reproducible results
    
    # 1. Roles
    roles = [
        { "id": 1, "name": "Admin", "slug": "admin" },
        { "id": 2, "name": "Teacher", "slug": "teacher" },
        { "id": 3, "name": "Student", "slug": "student" },
        { "id": 4, "name": "Accountant", "slug": "accountant" }
    ]
    
    # 2. Users & Employees (Teachers/Staff)
    users = []
    employees = []
    
    # Add Admin
    users.append({
        "id": 1,
        "name": "Super Administrator",
        "email": "admin@htu.edu.gh",
        "username": "admin",
        "role_id": 1,
        "status": "active"
    })
    
    # Add Accountant
    users.append({
        "id": 2,
        "name": "Francisca Osei",
        "email": "fosei@htu.edu.gh",
        "username": "fosei",
        "role_id": 4,
        "status": "active"
    })
    employees.append({
        "id": 1,
        "user_id": 2,
        "name": "Francisca Osei",
        "designation": "Head Accountant",
        "department": "Finance & Audit",
        "salary": 6200.00,
        "phone": "+233244888111",
        "joining_date": "2019-02-15"
    })
    
    # Add 12 Teachers
    user_id_counter = 3
    employee_id_counter = 2
    for i in range(12):
        name = f"Mr. {random.choice(first_names)} {random.choice(last_names)}"
        if i % 2 == 1:
            name = f"Mrs. {random.choice(first_names)} {random.choice(last_names)}"
            
        username = name.lower().replace("mr. ", "").replace("mrs. ", "").replace(" ", "")[:8]
        email = f"{username}@htu.edu.gh"
        
        users.append({
            "id": user_id_counter,
            "name": name,
            "email": email,
            "username": username,
            "role_id": 2,
            "status": "active"
        })
        
        employees.append({
            "id": employee_id_counter,
            "user_id": user_id_counter,
            "name": name,
            "designation": random.choice(designations),
            "department": random.choice(departments),
            "salary": float(random.randint(4500, 7500)),
            "phone": f"+2332{random.randint(0, 9)}{random.randint(1000000, 9999999)}",
            "joining_date": f"202{random.randint(0,4)}-0{random.randint(1,9)}-{random.randint(10,28)}"
        })
        
        user_id_counter += 1
        employee_id_counter += 1
        
    # 3. Classes and Sections
    classes = []
    sections = []
    section_id_counter = 1
    
    for idx, c_info in enumerate(classes_pool):
        class_id = idx + 1
        c_sections = []
        for sec_name in ["Section A", "Section B"]:
            c_sections.append(section_id_counter)
            sections.append({
                "id": section_id_counter,
                "class_id": class_id,
                "name": sec_name,
                "room_no": f"{class_id}0{section_id_counter % 2 + 1}"
            })
            section_id_counter += 1
            
        classes.append({
            "id": class_id,
            "name": c_info["name"],
            "numeric": c_info["numeric"],
            "sections": c_sections
        })
        
    # 4. Subjects
    subjects = []
    for idx, s_info in enumerate(subjects_pool):
        subjects.append({
            "id": idx + 1,
            "name": s_info["name"],
            "code": f"{s_info['code']}10{idx + 1}",
            "type": "practical" if "ICT" in s_info["name"] or "Science" in s_info["name"] else "theory"
        })
        
    # 5. Students & Student User Accounts (Generate 72 students, 8 per class)
    students = []
    student_id_counter = 1
    
    for class_obj in classes:
        sec_ids = class_obj["sections"]
        for roll in range(1, 9):
            first = random.choice(first_names)
            last = random.choice(last_names)
            name = f"{first} {last}"
            username = f"{first.lower()}{last.lower()[:3]}{random.randint(10,99)}"
            email = f"{username}@student.htu.edu.gh"
            
            # Generate student user account
            users.append({
                "id": user_id_counter,
                "name": name,
                "email": email,
                "username": username,
                "role_id": 3,
                "status": "active"
            })
            
            students.append({
                "id": student_id_counter,
                "user_id": user_id_counter,
                "name": name,
                "reg_no": f"HTU2026{student_id_counter:03d}",
                "roll_no": f"{roll:02d}",
                "class_id": class_obj["id"],
                "section_id": random.choice(sec_ids),
                "phone": f"+2335{random.randint(0, 9)}{random.randint(1000000, 9999999)}",
                "admission_date": f"2026-01-0{random.randint(5,9)}",
                "status": "active"
            })
            
            user_id_counter += 1
            student_id_counter += 1
            
    # 6. Exams
    exams = [
        {
            "id": 1,
            "name": "Mid-Term Examination",
            "term": "First Term",
            "start_date": "2026-03-10",
            "end_date": "2026-03-20",
            "status": "completed"
        },
        {
            "id": 2,
            "name": "Final Examination",
            "term": "First Term",
            "start_date": "2026-06-18",
            "end_date": "2026-06-30",
            "status": "scheduled"
        }
    ]
    
    # 7. Marks (Only for completed Mid-Term Exam 1, all students, random subjects)
    marks = []
    mark_id_counter = 1
    
    # Each student gets marks for 4 random subjects
    for student in students:
        selected_subjects = random.sample(subjects, 5)
        for sub in selected_subjects:
            class_work = random.randint(15, 30)
            exam = random.randint(30, 70)
            total = class_work + exam
            
            # Grade calculator
            if total >= 80:
                grade = "A"
            elif total >= 75:
                grade = "B+"
            elif total >= 70:
                grade = "B"
            elif total >= 65:
                grade = "C+"
            elif total >= 60:
                grade = "C"
            elif total >= 50:
                grade = "D"
            else:
                grade = "F"
                
            marks.append({
                "id": mark_id_counter,
                "student_id": student["id"],
                "subject_id": sub["id"],
                "exam_id": 1,
                "class_work_score": class_work,
                "exam_score": exam,
                "total_score": total,
                "grade": grade
            })
            mark_id_counter += 1
            
    # 8. Attendances (for 3 days: June 11, June 12, June 15)
    attendances = []
    att_id_counter = 1
    dates = ["2026-06-11", "2026-06-12", "2026-06-15"]
    
    for date in dates:
        for student in students:
            # 90% chance of present
            status = "present" if random.random() < 0.9 else "absent"
            remarks = "On time" if status == "present" else random.choice(["Sick leave", "Family emergency", "No show"])
            attendances.append({
                "id": att_id_counter,
                "student_id": student["id"],
                "date": date,
                "status": status,
                "remarks": remarks
            })
            att_id_counter += 1
            
    # 9. Finance Ledger (Tuition invoice & Feeding invoice for each student)
    finance_ledger = []
    ledger_id_counter = 1
    
    for student in students:
        # Tuition fee invoice
        tuition_fee = 1200.00
        paid_pct = random.choice([0.0, 0.5, 1.0])
        amount_paid = tuition_fee * paid_pct
        balance = tuition_fee - amount_paid
        pay_status = "paid" if balance == 0 else ("partial" if amount_paid > 0 else "unpaid")
        
        finance_ledger.append({
            "id": ledger_id_counter,
            "student_id": student["id"],
            "description": "First Term Tuition Fee",
            "amount_due": tuition_fee,
            "amount_paid": amount_paid,
            "balance": balance,
            "payment_status": pay_status,
            "date": "2026-01-10"
        })
        ledger_id_counter += 1
        
        # Feeding Program fee (only some students)
        if random.random() < 0.6:
            feeding_fee = 180.00
            paid_pct = random.choice([0.0, 1.0])
            amount_paid = feeding_fee * paid_pct
            balance = feeding_fee - amount_paid
            pay_status = "paid" if balance == 0 else "unpaid"
            
            finance_ledger.append({
                "id": ledger_id_counter,
                "student_id": student["id"],
                "description": "Feeding Program Fee (June)",
                "amount_due": feeding_fee,
                "amount_paid": amount_paid,
                "balance": balance,
                "payment_status": pay_status,
                "date": "2026-06-01"
            })
            ledger_id_counter += 1
            
    # Assembly
    data = {
        "roles": roles,
        "users": users,
        "classes": classes,
        "sections": sections,
        "subjects": subjects,
        "employees": employees,
        "students": students,
        "exams": exams,
        "marks": marks,
        "attendances": attendances,
        "finance_ledger": finance_ledger
    }
    
    # Save to file
    db_path = os.path.join(os.path.dirname(__file__), "dummy_db.json")
    with open(db_path, "w") as f:
        json.dump(data, f, indent=2)
        
    print(f"Generated successfully: {len(users)} users, {len(students)} students, {len(employees)} employees, {len(marks)} mark records, {len(attendances)} attendance records.")

if __name__ == "__main__":
    generate_data()
