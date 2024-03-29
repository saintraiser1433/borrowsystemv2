import { ref } from "vue";
export const AdminSideBar = ref([
  {
    icon: "mdi-monitor-dashboard",
    title: "Dashboard",
    path: "",
  },
  {
    icon: "mdi-account-multiple",
    title: "Borrower",
    items: [
      {
        title: "Department",
        path: "department",
      },
      {
        title: "Borrowers",
        path: "borrower",
      },
      {
        title: "For Approval Users",
        path: "userapproval",
      },
    ],
  },
  {
    icon: "mdi-package-variant",
    title: "Inventory",
    path: "inventory",
    items: [
      {
        title: "Category",
        path: "category",
      },
      {
        title: "Asset Master",
        path: "inventory",
      },
    ],
  },
  {
    icon: "mdi-keyboard-return",
    title: "Returned",
    path: "returned",
  },
  {
    icon: "mdi-source-branch",
    title: "Transactions",
    path: "transaction",
  },
  {
    icon: "mdi-file-chart",
    title: "Reports",
    path: "report",
  },
]);

export const clientSidebar = ref([
  {
    title: "Department",
    icon: "mdi-account-multiple",
    path: "department",
  },
  {
    title: "Borrowers",
    icon: "mdi-account-multiple",
    path: "borrower",
  },
  {
    title: "For Approval Users",
    icon: "mdi-account-multiple",
    path: "userapproval",
  },
]);
