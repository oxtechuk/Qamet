import { lazy, Suspense } from "react";
import type { ReactNode } from "react";
import { createBrowserRouter } from "react-router-dom";

import RootLayout from "../pages/RootLayout";
import HomePage from "../pages/HomePage";
import NotFoundPage from "../pages/NotFoundPage";
import LoadingSpinner from "../components/LoadingSpinner";

const AllCarsPage = lazy(() => import("../pages/AllCarsPage"));
const CarDetailsPage = lazy(() => import("../pages/CarDetailsPage"));
const ComparePage = lazy(() => import("../pages/ComparePage"));
const OffersPage = lazy(() => import("../pages/OffersPage"));
const AboutPage = lazy(() => import("../pages/AboutPage"));
const BlogsPage = lazy(() => import("../pages/BlogsPage"));
const BlogDetailsPage = lazy(() => import("../pages/BlogDetailsPage"));
const ContactPage = lazy(() => import("../pages/ContactPage"));
const FinanceCalculatorPage = lazy(() => import("../pages/FinanceCalculatorPage"));
const BrandsPage = lazy(() => import("../pages/BrandsPage"));
const OrdersPage = lazy(() => import("../pages/OrdersPage"));
const CorporateFinancePage = lazy(() => import("../pages/CorporateFinancePage"));

const withSuspense = (element: ReactNode) => (
  <Suspense fallback={<LoadingSpinner />}>{element}</Suspense>
);

function getRuntimeBasename() {
  const envBase = import.meta.env.BASE_URL || "/";
  if (typeof window === "undefined") return envBase;

  const currentPath = window.location.pathname;
  const cleanEnv = envBase.replace(/\/+$/, "");
  if (!cleanEnv || cleanEnv === "/") return "/";

  if (currentPath.toLowerCase().startsWith(cleanEnv.toLowerCase())) {
    return currentPath.slice(0, cleanEnv.length);
  }

  return envBase;
}

export const router = createBrowserRouter([
  {
    path: "/",
    Component: RootLayout,
    errorElement: <NotFoundPage />,
    children: [
      {
        index: true,
        Component: HomePage,
      },
      { path: "cars", element: withSuspense(<AllCarsPage />) },
      { path: "cars/:slug", element: withSuspense(<CarDetailsPage />) },
      { path: "compare", element: withSuspense(<ComparePage />) },
      { path: "offers", element: withSuspense(<OffersPage />) },
      {
        path: "about",
        element: withSuspense(<AboutPage />),
      },
      {
        path: "blog",
        element: withSuspense(<BlogsPage />),
      },
      {
        path: "blog/:slug",
        element: withSuspense(<BlogDetailsPage />),
      },
      {
        path: "contact",
        element: withSuspense(<ContactPage />),
      },
      {
        path: "finance-calculator",
        element: withSuspense(<FinanceCalculatorPage />),
      },
      {
        path: "brands",
        element: withSuspense(<BrandsPage />),
      },
      {
        path: "orders",
        element: withSuspense(<OrdersPage />),
      },
      {
        path: "corporate",
        element: withSuspense(<CorporateFinancePage />),
      },
      {
        path: "corporate-finance",
        element: withSuspense(<CorporateFinancePage />),
      },
      {
        path: "*",
        Component: NotFoundPage,
      },
    ],
  },
], {
  basename: getRuntimeBasename(),
});

