# Portfolio Database — SQL Documentation

This document explains the structure of the `portfolio_db` MySQL database used by the portfolio website and admin panel.

## 1. Database

```sql
CREATE DATABASE portfolio_db;
USE portfolio_db;
```

The database is named `portfolio_db`. All portfolio information is stored inside this database.

## 2. Database Structure

The database contains six main tables:

| Table              | Purpose                                      |
| ------------------ | -------------------------------------------- |
| `profile`          | Personal information, bio, statistics and CV |
| `projects`         | Portfolio projects                           |
| `experience`       | Work experience                              |
| `education`        | Education and academic information           |
| `certificates`     | Certifications and credentials               |
| `contact_messages` | Messages submitted through the contact form  |

## 3. `profile` Table

The `profile` table stores information about the portfolio owner.

Important fields:

* `id` — Unique profile ID. It defaults to `1` because the portfolio has one main profile.
* `name` — Portfolio owner's name.
* `tagline` — Short professional tagline.
* `hero_title` — Main heading displayed in the hero section.
* `bio` — Short professional biography.
* `about_text` — Longer About section content.
* `status_text` — Availability/status shown on the website.
* `location` — Current location.
* `email` — Contact email.
* `resume_url` — Location or URL of the CV/resume.
* `years_exp` — Number of years of experience.
* `articles_written` — Number of articles written.
* `updated_at` — Automatically records the latest update time.

### CRUD

Because this is a single profile record, the admin panel mainly needs:

* **Read** — Display profile information.
* **Update** — Edit profile information.

Create and Delete are normally unnecessary for the main profile.

## 4. `projects` Table

Stores all projects displayed on the portfolio.

Important fields:

* `id` — Automatically generated project ID.
* `title` — Project name.
* `description` — Project description.
* `tech_stack` — Technologies used in the project.
* `project_url` — Live website or GitHub URL.
* `image_path` — Project image location.
* `created_at` — Date the project was created.

### CRUD

The admin panel should support:

* **Create** — Add a new project.
* **Read** — View projects.
* **Update** — Edit project details.
* **Delete** — Remove a project.

## 5. `experience` Table

Stores professional and internship experience.

Important fields:

* `id` — Unique experience ID.
* `role_title` — Job or internship position.
* `company` — Company or organization name.
* `employment_type` — Full-time, internship, freelance, etc.
* `timeline` — Employment period.
* `location` — Work location.
* `skills_used` — Skills used in that position.
* `created_at` — Record creation date.

### CRUD

The admin panel should allow the administrator to add, view, edit and delete experience records.

## 6. `education` Table

Stores educational qualifications.

Important fields:

* `id` — Unique education ID.
* `degree` — Degree or qualification.
* `institution` — College or university.
* `gpa` — GPA or academic result.
* `timeline` — Study period.
* `skills_covered` — Relevant skills or subjects.
* `created_at` — Record creation date.

### CRUD

The admin panel should support Create, Read, Update and Delete operations.

## 7. `certificates` Table

Stores licenses, certificates and professional credentials.

Important fields:

* `id` — Unique certificate ID.
* `title` — Certificate name.
* `issuer` — Organization that issued the certificate.
* `issue_date` — Date or period associated with the certificate.
* `credential_url` — Link to verify or view the credential.
* `skills_covered` — Skills demonstrated by the certificate.
* `created_at` — Record creation date.

### CRUD

The admin panel should support:

* Add certificate
* View certificates
* Edit certificate
* Delete certificate

## 8. `contact_messages` Table

Stores messages submitted by visitors through the portfolio contact form.

Important fields:

* `id` — Unique message ID.
* `name` — Visitor's name.
* `email` — Visitor's email.
* `subject` — Message subject.
* `message` — Message content.
* `created_at` — Submission time.

### Admin Operations

The admin panel can provide:

* **Read** — View received messages.
* **Delete** — Remove unwanted or handled messages.

Update is usually unnecessary because contact messages should preserve what the visitor originally submitted.

## 9. Admin Panel CRUD Flow

The admin dashboard should connect directly to the database through a secure backend.

```text
Admin Login
     ↓
Admin Dashboard
     ↓
Choose Section
     ↓
Projects / Experience / Education / Certificates / Profile
     ↓
Create → Database → Live Portfolio
Read   → Database → Live Portfolio
Update → Database → Live Portfolio
Delete → Database → Live Portfolio
```

When an administrator updates information in the dashboard, the public portfolio should retrieve the latest data from MySQL instead of using hard-coded content.

## 10. Public Portfolio Data Flow

```text
MySQL Database
      ↓
Backend / API
      ↓
Portfolio Frontend
      ↓
Visitor
```

For example, when a new project is added through the admin panel:

```text
Admin adds project
        ↓
Backend validates data
        ↓
Project saved in `projects`
        ↓
Portfolio requests projects
        ↓
New project appears on website
```

## 11. Recommended Admin Routes

Example backend routes:

```text
POST   /admin/login
GET    /api/profile
PUT    /api/profile

GET    /api/projects
POST   /api/projects
PUT    /api/projects/:id
DELETE /api/projects/:id

GET    /api/experience
POST   /api/experience
PUT    /api/experience/:id
DELETE /api/experience/:id

GET    /api/education
POST   /api/education
PUT    /api/education/:id
DELETE /api/education/:id

GET    /api/certificates
POST   /api/certificates
PUT    /api/certificates/:id
DELETE /api/certificates/:id

GET    /api/contact-messages
DELETE /api/contact-messages/:id
```

## 12. Important Security Notes

The database should **never be accessed directly from frontend JavaScript**.

Use this structure:

```text
Frontend → Backend/API → MySQL
```

Do not expose MySQL credentials in frontend code.

The admin panel should also have:

* Secure admin authentication
* Password hashing
* Session/JWT protection
* Authorization checks
* Input validation
* SQL injection protection using prepared statements
* CSRF protection where applicable
* File upload validation for project images and resumes

## 13. Overall Architecture

```text
                  ┌──────────────────┐
                  │   Admin Panel    │
                  └────────┬─────────┘
                           │
                           ↓
                  ┌──────────────────┐
                  │   Backend / API  │
                  └────────┬─────────┘
                           │
                           ↓
                  ┌──────────────────┐
                  │    portfolio_db  │
                  └────────┬─────────┘
                           │
          ┌────────────────┼────────────────┐
          ↓                ↓                ↓
      `profile`       `projects`      `experience`
          ↓                ↓                ↓
      `education`    `certificates`   `contact_messages`
                           │
                           ↓
                  ┌──────────────────┐
                  │ Public Portfolio │
                  └──────────────────┘
```

This database design gives the portfolio a dynamic content-management system: instead of manually editing HTML whenever your information changes, you can manage your profile, projects, experience, education and certificates from the admin panel.
