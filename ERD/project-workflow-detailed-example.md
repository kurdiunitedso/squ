# Detailed Project Workflow Example

## 1. Project Setup
- Create a new project in the PROJECTS table:
  ```
  ID: 1001
  Title: "TechGadget Q2 Campaign"
  Frequency: 30
  Duration: 90
  Posts_per_cycle: 10
  Start_date: 2024-04-01
  End_date: 2024-06-30
  Art_manager_id: 201
  ```

## 2. Define Workflow
Insert into PROJECT_EMPLOYEES_WORKFLOW:
```
(1001, 101, 1) - Content Creator
(1001, 102, 2) - Graphic Designer
(1001, 103, 3) - Copywriter
(1001, 104, 4) - Social Media Manager
```

## 3. Set Exception Days
Assuming we have a DAYS table with day_id and day_name:
- Insert into PROJECT_EXCEPTION_DAYS: `(1001, 7)` - Assuming 7 represents Sunday in the DAYS table

## 4. Generate Tasks
The system generates 30 tasks (10 posts * 3 months) in the TASKS table. For April (similar for May and June):
```
(2001, 1001, "Placeholder Title 1", "Placeholder Description", 2024-04-02, "Pending", false, false)
(2002, 1001, "Placeholder Title 2", "Placeholder Description", 2024-04-04, "Pending", false, false)
...
(2010, 1001, "Placeholder Title 10", "Placeholder Description", 2024-04-30, "Pending", false, false)
```

## 5. Account Manager Input
The account manager updates each task with specific titles and descriptions:
```sql
UPDATE TASKS 
SET title = "New Product Launch", 
    description = "Announce our latest smartwatch" 
WHERE id = 2001;
```

## 6. Task Assignment and Workflow
Let's follow Task 2001:

### a. Assign to Content Creator
Insert into TASK_ASSIGNMENTS:
```
(3001, 2001, 101, 102, true, '2024-04-02 09:00:00', NULL, false)
```

### b. Content Creator completes work
Insert into TASK_PROCESSES:
```
(4001, 3001, 101, "Created initial content brief for new product launch")
```

### c. Art Manager Approval
```sql
UPDATE TASK_ASSIGNMENTS 
SET art_manager_approved = true 
WHERE id = 3001;
```

### d. Move to Graphic Designer
```sql
UPDATE TASK_ASSIGNMENTS 
SET active = false, end_date = '2024-04-03 15:00:00' 
WHERE id = 3001;

INSERT INTO TASK_ASSIGNMENTS 
(id, task_id, employee_id, next_employee_id, active, start_date, art_manager_approved)
VALUES 
(3002, 2001, 102, 103, true, '2024-04-03 15:01:00', false);
```

### e. Repeat steps b-d for Graphic Designer, Copywriter, and Social Media Manager

## 7. Customer Approval (if required)
If the Art Manager decides customer approval is needed:
```sql
UPDATE TASKS 
SET customer_approval_required = true 
WHERE id = 2001;
```

After customer reviews:
```sql
UPDATE TASKS 
SET customer_approved = true 
WHERE id = 2001;
```

## 8. Final Approval and Scheduling
When the Social Media Manager completes their task:
```sql
UPDATE TASK_ASSIGNMENTS 
SET active = false, 
    end_date = '2024-04-05 16:00:00', 
    art_manager_approved = true 
WHERE id = 3004 AND task_id = 2001;

UPDATE TASKS 
SET status = 'Completed' 
WHERE id = 2001;
```

## 9. Parallel Processing
While Task 2001 is progressing, other tasks are also moving through the workflow simultaneously, following the same process.

## 10. Exception Day Handling
Before scheduling each task, check if the date is in PROJECT_EXCEPTION_DAYS. If it is, move to the next available day.

---

This process repeats for all 30 tasks over the 90-day period. The system ensures that:
- Each task goes through every step of the workflow in order
- The Art Manager approves each step before it moves to the next employee
- Customer approval is tracked when required
- Tasks are not scheduled on exception days
- 10 posts are created and published each month

This setup allows for flexibility in workflow, handles exceptions, includes approval processes, and maintains a detailed record of each task's progress through the system.

