import { lazy, Suspense } from "react";
import type { ReactNode } from "react";
import { createBrowserRouter } from "react-router-dom";

import RootLayout from "../pages/RootLayout";
import HomePage from "../pages/HomePage";
import NotFoundPage from "../pages/NotFoundPage";

import AllCarsPageSkeleton from "../components/skeletons/AllCarsPageSkeleton";
import AboutPageSkeleton from "../components/skeletons/AboutPageSkeleton";
import BlogsPageSkeleton from "../components/skeletons/BlogsPageSkeleton";
import BlogDetailsPageSkeleton from "../components/skeletons/BlogDetailsPageSkeleton";
import BrandsPageSkeleton from "../components/skeletons/BrandsPageSkeleton";
import CarDetailsPageSkeleton from "../components/skeletons/CarDetailsPageSkeleton";
import ContactPageSkeleton from "../components/skeletons/ContactPageSkeleton";
import HomePageSkeleton from "../components/skeletons/HomePageSkeleton";
import OffersPageSkeleton from "../components/skeletons/OffersPageSkeleton";

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

const withSuspense = (fallback: ReactNode, element: ReactNode) => (
  <Suspense fallback={fallback}>{element}</Suspense>
);

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
      { path: "/cars", element: withSuspense(<AllCarsPageSkeleton />, <AllCarsPage />) },
      {
        path: "/cars/:slug",
        element: withSuspense(<CarDetailsPageSkeleton />, <CarDetailsPage />),
      },
      { path: "/compare", element: withSuspense(<HomePageSkeleton />, <ComparePage />) },
      { path: "/offers", element: withSuspense(<OffersPageSkeleton />, <OffersPage />) },
      {
        path: "/about",
        element: withSuspense(<AboutPageSkeleton />, <AboutPage />),
      },
      {
        path: "/blog",
        element: withSuspense(<BlogsPageSkeleton />, <BlogsPage />),
      },
      {
        path: "/blog/:slug",
        element: withSuspense(<BlogDetailsPageSkeleton />, <BlogDetailsPage />),
      },
      {
        path: "/contact",
        element: withSuspense(<ContactPageSkeleton />, <ContactPage />),
      },
      {
        path: "/finance-calculator",
        element: withSuspense(<HomePageSkeleton />, <FinanceCalculatorPage />),
      },
      {
        path: "/brands",
        element: withSuspense(<BrandsPageSkeleton />, <BrandsPage />),
      },
      {
        path: "/orders",
        element: withSuspense(<HomePageSkeleton />, <OrdersPage />),
      },
      {
        path: "*",
        Component: NotFoundPage,
      },
    ],
  },
], {
  basename: import.meta.env.BASE_URL,
});
