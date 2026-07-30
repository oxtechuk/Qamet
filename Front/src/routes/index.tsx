import { createBrowserRouter } from "react-router-dom";

import RootLayout from "../pages/RootLayout";
import HomePage from "../pages/HomePage";
import NotFoundPage from "../pages/NotFoundPage";
import AllCarsPage from "../pages/AllCarsPage";
import CarDetailsPage from "../pages/CarDetailsPage";
import ComparePage from "../pages/ComparePage";
import OffersPage from "../pages/OffersPage";
import AboutPage from "../pages/AboutPage";
import BlogsPage from "../pages/BlogsPage";
import BlogDetailsPage from "../pages/BlogDetailsPage";
import ContactPage from "../pages/ContactPage";
import FinanceCalculatorPage from "../pages/FinanceCalculatorPage";
import BrandsPage from "../pages/BrandsPage";
import OrdersPage from "../pages/OrdersPage";

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
      { path: "/cars", element: <AllCarsPage /> },
      { path: "/cars/:slug", element: <CarDetailsPage /> },
      { path: "/compare", element: <ComparePage /> },
      { path: "/offers", element: <OffersPage /> },
      {
        path: "/about",
        element: <AboutPage />,
      },
      {
        path: "/blog",
        element: <BlogsPage />,
      },
      {
        path: "/blog/:slug",
        element: <BlogDetailsPage />,
      },
      {
        path: "/contact",
        element: <ContactPage />,
      },
      {
        path: "/finance-calculator",
        element: <FinanceCalculatorPage />,
      },
      {
        path: "/brands",
        element: <BrandsPage />,
      },
      {
        path: "/orders",
        element: <OrdersPage />,
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
