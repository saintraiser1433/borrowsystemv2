import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: '/',
    name: 'Login',
    component: () => import("@/views/auth/Login.vue")
  },
  {
    path: '/signup',
    name: 'Signup',
    component: () => import("@/views/auth/Signup.vue")
  },
  {
    path: '/admin',
    component: () => import("@/layout/AdminLayout.vue"),
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('isAuthenticated') && localStorage.getItem('role') === 'FACULTY') {
        next();
      } else {
        next('../');
      }
    },
    children: [
      {
        path: "",
        name: "Dashboard",
        component: () => import("@/views/admin/Dashboard.vue"),
        meta: {
          title: "Dashboard",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "borrower",
        name: "Borrower",
        component: () => import("@/views/admin/Borrower.vue"),
        meta: {
          title: "Manage Borrower",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "category",
        name: "Category",
        component: () => import("@/views/admin/Category.vue"),
        meta: {
          title: "Manage Categories",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "department",
        name: "Department",
        component: () => import("@/views/admin/Department.vue"),
        meta: {
          title: "Manage Department",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "userapproval",
        name: "Approval",
        component: () => import("@/views/admin/UserApproval.vue"),
        meta: {
          title: "Manage Approval Borrower",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "inventory",
        name: "Inventory",
        component: () => import("@/views/admin/Inventory.vue"),
        meta: {
          title: "Manage Inventory",
          subtitle: "This panel represents list of assets available in science laboratory.",
        },
      },
      {
        path: "returned",
        name: "Returned",
        component: () => import("@/views/admin/Returned.vue"),
        meta: {
          title: "Manage Returned Item",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "transaction",
        name: "Transaction",
        component: () => import("@/views/admin/Transactions.vue"),
        meta: {
          title: "Manage Transaction",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
      {
        path: "report",
        name: "Report",
        component: () => import("@/views/admin/Reports.vue"),
        meta: {
          title: "Manage Report",
          subtitle: "Lorem ipsum dolor sit amet consectetur adipisicing elit.",
        },
      },
    ]
  },
  {
    path: '/user',
    component: () => import("@/layout/UserLayout.vue"),
    beforeEnter: (to, from, next) => {
      if (localStorage.getItem('isAuthenticated') && localStorage.getItem('role') === 'STUDENT') {
        next();
      } else {
        next('../');
      }
    },
    children: [
      {
        path: '',
        name: 'UserDashboard',
        component: () => import("@/views/user/Test1.vue"),
      },
    ]
  },
  {
    path: "/:pathMatch(.*)*", component: () => import("@/components/PageNotFound.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
