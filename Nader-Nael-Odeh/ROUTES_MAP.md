# Laravel Routes Map

This document maps all URLs to their route names and Blade view files.

## Public Routes

| URL | Route Name | View File | Description |
|-----|------------|-----------|-------------|
| `/` | - | `public.index` | Home page - Questions feed |
| `/index` | - | `public.index` | Home page (alias) |
| `/lawyers` | - | `public.lawyers` | Browse lawyers directory |
| `/blog` | - | `public.blog` | Blog/Articles listing |
| `/ask-question` | - | `public.ask-question` | Ask a question form |
| `/question-details` | - | `public.question-details` | Question details page |
| `/login` | - | `public.login` | Login page |
| `/register` | - | `public.register` | Registration page |
| `/lawyer-request` | - | `public.lawyer-request` | Lawyer verification request |
| `/lawyer-profile` | - | `public.lawyer-profile` | Lawyer profile view |
| `/edit-lawyer-profile` | - | `public.edit-lawyer-profile` | Edit lawyer profile |
| `/new-article` | - | `public.new-article` | Write new article |
| `/edit-article` | - | `public.edit-article` | Edit article |
| `/my-articles` | - | `public.my-articles` | My articles list |
| `/article-details` | - | `public.article-details` | Article details page |

## Admin Routes

All admin routes are prefixed with `/admin`

| URL | Route Name | View File | Description |
|-----|------------|-----------|-------------|
| `/admin` | - | Redirect to `/admin/dashboard` | Admin root redirect |
| `/admin/dashboard` | - | `admin.dashboard` | Admin dashboard |
| `/admin/users` | - | `admin.users` | Users management |
| `/admin/lawyer-requests` | - | `admin.lawyer-requests` | Lawyer verification requests |
| `/admin/questions` | - | `admin.questions` | Questions management |
| `/admin/articles` | - | `admin.articles` | Articles management |
| `/admin/categories` | - | `admin.categories` | Categories management |

## Navigation Links Verification

### Public Navbar Links
- ✅ Home/Questions → `/`
- ✅ Lawyers → `/lawyers`
- ✅ Blog → `/blog`
- ✅ Ask Question → `/ask-question` (role-based)
- ✅ Write Article → `/new-article` (role-based)
- ✅ My Articles → `/my-articles` (role-based)
- ✅ Sign In → `/login`
- ✅ Sign Up → `/register`

### Admin Sidebar Links
- ✅ Dashboard → `/admin/dashboard`
- ✅ Users → `/admin/users`
- ✅ Lawyer Requests → `/admin/lawyer-requests`
- ✅ Questions → `/admin/questions`
- ✅ Articles → `/admin/articles`
- ✅ Categories → `/admin/categories`
- ✅ Public Site → `/` (external link)

## Notes

- All routes use simple closures returning views
- No named routes are currently defined (can be added later if needed)
- All links use `{{ url('/path') }}` helper for consistency
- Admin routes are grouped with `/admin` prefix
- Authentication/authorization is not implemented (demo mode only)
