```
# Codex Task: MVC Controller Refactoring & Auth Logic Overhaul
 
You are an expert software engineer specializing in clean architecture, backend optimization, and secure authentication workflows within MVC frameworks.
 
I want to completely rewrite and optimize the core logic behind my **Login** and **Signup** systems. While the underlying logic must be replaced and modernized for efficiency and security, you must strictly respect and maintain my existing **MVC (Model-View-Controller)** architecture, folder structure, and how these components interact.
 
## 1. Architectural Constraints
* **Preserve MVC Structure:** Do not alter the folder layout, file names, or the way the Controller communicates with Models and Views. Keep the existing routing and controller instantiation methods intact.
* **Controller Optimization:** Clean up the Controller by removing bloated, redundant, or messy code. Ensure it acts strictly as a clean coordinator that captures requests, calls the appropriate Model methods, and handles responses/views.
 
## 2. New Logic & Security Implementation Requirements
 
### A. Signup (Account Creation) Logic
* **Strict Duplicate Validation:** Before inserting any data, perform an efficient database check via the Model to see if the user already exists (e.g., matching email or username). 
* **Early Return / Fail Fast:** If a duplicate is found, immediately halt execution, return `false` (or trigger your framework's standard error state), and prevent any data from being written.
* **Modern Password Security:** Ensure passwords are securely hashed using modern, standard hashing algorithms (e.g., `password_hash()` with `PASSWORD_BCRYPT` in PHP) before database insertion.
 
### B. Login Logic
* **Secure Verification:** Implement robust credential verification (e.g., pulling the user by identifier and verifying the password using secure timing-attack-safe methods like `password_verify()`).
* **Session & State Management:** Cleanly initialize the user session or state upon a successful login match, and return an explicit success or failure state to the controller to handle redirect/error views.
 
## 3. Expected Output
Please provide:
1. **The completely rewritten Controller and Model code blocks** adhering to the new logic.
2. **A concise, bulleted summary** explaining the changes made to the logic, the security improvements, and how the MVC relationship was maintained.
 
---