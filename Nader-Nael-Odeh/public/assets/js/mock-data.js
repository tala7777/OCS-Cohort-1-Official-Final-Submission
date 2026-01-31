window.app = window.app || {};

// Mock Data Seed with Unified Categories
window.app.defaultCategories = [
    { id: 1, name: "Corporate Law", is_active: true },
    { id: 2, name: "Family Law", is_active: true },
    { id: 3, name: "IP Law", is_active: true },
    { id: 4, name: "Real Estate", is_active: true },
    { id: 5, name: "Criminal Law", is_active: true },
    { id: 6, name: "Employment Law", is_active: true },
    { id: 7, name: "Tax Law", is_active: true },
    { id: 8, name: "Banking Law", is_active: true }
];

window.app.db = {
    stats: {
        admin: { users: 1540, approved_lawyers: 420, pending_requests: 12, questions: 620, answers: 1250, articles: 310 },
        lawyer: { my_answers: 42, my_articles: 5, profile_views: 1240, specialization: "Criminal Law" },
        user: { my_questions: 8, answered_questions: 5, open_questions: 3, saved_lawyers: 4 }
    },
    users: [
        { id: 101, name: "John Doe", email: "john@client.com", role: "User", status: "Active", joined: "2023-01-15", avatar: "https://ui-avatars.com/api/?name=John+Doe&background=2563eb&color=fff" },
        { id: 102, name: "Sarah Connor", email: "sarah@client.com", role: "User", status: "Active", joined: "2023-02-10", avatar: "https://ui-avatars.com/api/?name=Sarah+Connor&background=2563eb&color=fff" },
        { id: 103, name: "James McGill", email: "jimmy@lawyer.com", role: "Lawyer", status: "Active", joined: "2023-03-05", specialization: "Criminal Law", bio: "Better Call Saul!", phone: "+1 505 555 0100", totalAnswers: 42, totalArticles: 5, avatar: "https://ui-avatars.com/api/?name=James+McGill&background=0f2b46&color=fff" },
        { id: 104, name: "Kim Wexler", email: "kim@lawyer.com", role: "Lawyer", status: "Active", joined: "2023-03-05", specialization: "Banking Law", bio: "Excellence in every case.", phone: "+1 505 555 0199", totalAnswers: 30, totalArticles: 8, avatar: "https://ui-avatars.com/api/?name=Kim+Wexler&background=0f2b46&color=fff" },
        { id: 105, name: "Walter White", email: "walter@client.com", role: "User", status: "Suspended", joined: "2023-04-20", avatar: "https://ui-avatars.com/api/?name=Walter+White&background=2563eb&color=fff" },
        { id: 106, name: "Alicia Florrick", email: "alicia@florrick.com", role: "Lawyer", status: "Active", joined: "2023-06-15", specialization: "Family Law", bio: "Dedicated to your family's future.", phone: "+1 312 555 0122", totalAnswers: 15, totalArticles: 2, avatar: "https://ui-avatars.com/api/?name=Alicia+Florrick&background=0f2b46&color=fff" },
        { id: 107, name: "Admin User", email: "admin@legalqna.com", role: "Admin", status: "Active", joined: "2022-01-01", avatar: "https://ui-avatars.com/api/?name=Admin+User&background=000&color=fff" }
    ],
    lawyerRequests: [
        { id: 501, name: "Harvey Specter", email: "harvey@pearson.com", specialization: "Corporate Law", status: "Pending", date: "2024-01-10" },
        { id: 502, name: "Louis Litt", email: "louis@pearson.com", specialization: "Corporate Law", status: "Pending", date: "2024-01-11" },
        { id: 503, name: "Mike Ross", email: "mike@fake.com", specialization: "Corporate Law", status: "Rejected", date: "2023-12-05" },
        { id: 504, name: "Alicia Florrick", email: "alicia@florrick.com", specialization: "Family Law", status: "Approved", date: "2023-06-10" },
    ],
    questions: [
        { 
            id: 201, 
            title: "Intellectual Property rights for software", 
            body: "I have developed a new sorting algorithm and I want to know if I can patent it or if copyright involves code only.",
            askedBy: "John Doe", authorId: 101, category: "IP Law", status: "Answered", date: "2024-01-12", views: 150
        },
        { 
            id: 202, 
            title: "Divorce proceedings processing time", 
            body: "How long does a mutual consent divorce usually take in the state of New York?",
            askedBy: "Sarah Connor", authorId: 102, category: "Family Law", status: "Answered", date: "2024-01-10", views: 340
        },
        { 
            id: 203, 
            title: "Tenancy agreement dispute", 
            body: "My landlord refuses to return my deposit claiming damage that was there when I moved in.",
            askedBy: "Walter White", authorId: 105, category: "Real Estate", status: "Answered", date: "2023-12-20", views: 520
        },
        { 
            id: 204, 
            title: "Starting a business LLC vs Corp", 
            body: "I am starting a tech consultancy. Should I go for LLC or C-Corp?",
            askedBy: "John Doe", authorId: 101, category: "Corporate Law", status: "Open", date: "2024-01-13", views: 45
        }
    ],
    answers: [
        { id: 301, questionId: 201, lawyerId: 104, lawyerName: "Kim Wexler", content: "Algorithms are hard to patent, but implementation is copyrightable.", date: "2024-01-12" },
        { id: 302, questionId: 203, lawyerId: 103, lawyerName: "James McGill", content: "Small claims court is your best friend here.", date: "2023-12-21" },
        { id: 303, questionId: 202, lawyerId: 106, lawyerName: "Alicia Florrick", content: "Typically 3-6 months for uncontested cases.", date: "2024-01-11" }
    ],
    articles: [
        { id: 801, title: "5 Tips for First-Time Home Buyers", authorId: 103, authorName: "James McGill", category: "Real Estate", date: "2023-11-15", views: 1200, content: "Lorem ipsum dolor sit amet..." },
        { id: 802, title: "Understanding IP Law in 2024", authorId: 104, authorName: "Kim Wexler", category: "IP Law", date: "2024-01-05", views: 850, content: "Ut enim ad minim veniam..." },
        { id: 803, title: "Custody Battles: What to Expect", authorId: 106, authorName: "Alicia Florrick", category: "Family Law", date: "2023-12-10", views: 920, content: "Duis aute irure dolor..." }
    ],
    categories: [] 
};
