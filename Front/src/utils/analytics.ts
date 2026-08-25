declare global {
  interface Window {
    dataLayer?: any[];
    fbq?: (...args: any[]) => void;
    ttq?: {
      page: () => void;
      track: (event: string, params?: Record<string, any>, options?: Record<string, any>) => void;
      identify: (params?: Record<string, any>) => void;
      [key: string]: any;
    };
    snaptr?: (action: string, eventName?: string, params?: Record<string, any>) => void;
  }
}

/**
 * Generate a unique event_id for client-server deduplication
 */
export function generateEventId(prefix = "evt"): string {
  const timestamp = Date.now();
  const random = Math.random().toString(36).substring(2, 10);
  return `${prefix}_${timestamp}_${random}`;
}

/**
 * Flag to skip the very first SPA PageView call when the pixel already
 * fired a PageView from index.html on initial load.
 */
let _firstPageViewSent = false;

/**
 * Track SPA PageView across GTM, Meta Pixel, TikTok Pixel, and Snapchat Pixel.
 * Skips the first call to avoid duplicating the PageView already fired by
 * the inline pixel snippet in index.html on initial page load.
 */
export function trackPageView(path: string, title?: string): void {
  // On the very first render the pixel in index.html already fired a PageView.
  // Skip here and mark as handled so subsequent SPA navigations are tracked.
  if (!_firstPageViewSent) {
    _firstPageViewSent = true;
    return;
  }

  try {
    const pageTitle = title || document.title;
    const pageUrl = window.location.href;

    // GTM dataLayer
    if (window.dataLayer && Array.isArray(window.dataLayer)) {
      window.dataLayer.push({
        event: "page_view",
        page_path: path,
        page_title: pageTitle,
        page_location: pageUrl,
      });
    }

    // Meta Pixel
    if (typeof window.fbq === "function") {
      window.fbq("track", "PageView");
    }

    // TikTok Pixel
    if (window.ttq && typeof window.ttq.page === "function") {
      window.ttq.page();
    }

    // Snapchat Pixel
    if (typeof window.snaptr === "function") {
      window.snaptr("track", "PAGE_VIEW");
    }
  } catch (err) {
    console.debug("[Analytics] trackPageView error:", err);
  }
}

/**
 * Track 404 Not Found pages as a custom event so they can be filtered
 * out in Meta Events Manager and excluded from conversion reports.
 */
export function track404Page(path?: string): void {
  try {
    const page = path || window.location.pathname;

    // GTM dataLayer — custom event for filtering in GA4 / GTM
    if (window.dataLayer && Array.isArray(window.dataLayer)) {
      window.dataLayer.push({
        event: "page_not_found",
        page_path: page,
        page_location: window.location.href,
      });
    }

    // Meta Pixel — custom event (filterable in Events Manager)
    if (typeof window.fbq === "function") {
      window.fbq("trackCustom", "PageNotFound", { page_path: page });
    }

    // TikTok Pixel
    if (window.ttq && typeof window.ttq.track === "function") {
      window.ttq.track("PageNotFound", { page_path: page });
    }

    // Snapchat Pixel
    if (typeof window.snaptr === "function") {
      window.snaptr("track", "CUSTOM_EVENT_2", { event_name: "page_not_found", page_path: page });
    }
  } catch (err) {
    console.debug("[Analytics] track404Page error:", err);
  }
}

export interface ITrackViewContentProps {
  carId?: number | string;
  carName: string;
  brand?: string;
  price?: number;
  currency?: string;
}

/**
 * Track ViewContent when a user views a car details page
 */
export function trackViewContent({
  carId,
  carName,
  brand,
  price,
  currency = "SAR",
}: ITrackViewContentProps): void {
  try {
    const contentId = carId ? String(carId) : carName;

    // GTM
    if (window.dataLayer && Array.isArray(window.dataLayer)) {
      window.dataLayer.push({
        event: "view_item",
        ecommerce: {
          currency,
          value: price ?? 0,
          items: [
            {
              item_id: contentId,
              item_name: carName,
              item_brand: brand ?? "",
              price: price ?? 0,
            },
          ],
        },
      });
    }

    // Meta Pixel
    if (typeof window.fbq === "function") {
      window.fbq("track", "ViewContent", {
        content_name: carName,
        content_category: brand ?? "Car",
        content_ids: [contentId],
        content_type: "product",
        value: price ?? 0,
        currency,
      });
    }

    // TikTok Pixel
    if (window.ttq && typeof window.ttq.track === "function") {
      window.ttq.track("ViewContent", {
        content_id: contentId,
        content_type: "product",
        content_name: carName,
        value: price ?? 0,
        currency,
      });
    }

    // Snapchat Pixel
    if (typeof window.snaptr === "function") {
      window.snaptr("track", "VIEW_CONTENT", {
        item_ids: [contentId],
        item_category: brand ?? "Car",
        price: price ?? 0,
        currency,
      });
    }
  } catch (err) {
    console.debug("[Analytics] trackViewContent error:", err);
  }
}

export interface ITrackLeadProps {
  eventId?: string;
  formName: "cash_order" | "installment_order" | "corporate_order" | "contact_form";
  carName?: string;
  orderType?: "cash" | "finance" | "corporate";
  name?: string;
  phone?: string;
  email?: string;
  value?: number;
  currency?: string;
}

/**
 * Track Lead / SubmitForm when a user submits an order or booking form
 */
export function trackLead({
  eventId,
  formName,
  carName,
  orderType,
  value,
  currency = "SAR",
}: ITrackLeadProps): string {
  const event_id = eventId || generateEventId("lead");

  try {
    // GTM
    if (window.dataLayer && Array.isArray(window.dataLayer)) {
      window.dataLayer.push({
        event: "generate_lead",
        event_id,
        form_name: formName,
        car_name: carName ?? "",
        order_type: orderType ?? "",
        value: value ?? 0,
        currency,
      });
    }

    // Meta Pixel with eventID for CAPI deduplication
    if (typeof window.fbq === "function") {
      window.fbq(
        "track",
        "Lead",
        {
          content_name: carName || formName,
          content_category: orderType || "Vehicle Inquiry",
          value: value ?? 0,
          currency,
        },
        { eventID: event_id }
      );
    }

    // TikTok Pixel with event_id
    if (window.ttq && typeof window.ttq.track === "function") {
      window.ttq.track(
        "SubmitForm",
        {
          content_name: carName || formName,
          content_type: "lead",
          value: value ?? 0,
          currency,
        },
        { event_id }
      );
    }

    // Snapchat Pixel
    if (typeof window.snaptr === "function") {
      window.snaptr("track", "SIGN_UP", {
        item_category: formName,
        price: value ?? 0,
        currency,
        client_dedup_id: event_id,
      });
    }
  } catch (err) {
    console.debug("[Analytics] trackLead error:", err);
  }

  return event_id;
}

/**
 * Track Contact (WhatsApp / Phone Call clicks)
 */
export function trackContact(method: "whatsapp" | "call" | "form"): void {
  try {
    // GTM
    if (window.dataLayer && Array.isArray(window.dataLayer)) {
      window.dataLayer.push({
        event: "contact_click",
        contact_method: method,
      });
    }

    // Meta Pixel
    if (typeof window.fbq === "function") {
      window.fbq("track", "Contact", {
        content_name: `Contact via ${method}`,
      });
    }

    // TikTok Pixel
    if (window.ttq && typeof window.ttq.track === "function") {
      window.ttq.track("Contact", {
        content_type: method,
      });
    }

    // Snapchat Pixel
    if (typeof window.snaptr === "function") {
      window.snaptr("track", "CUSTOM_EVENT_1", {
        event_name: `contact_${method}`,
      });
    }
  } catch (err) {
    console.debug("[Analytics] trackContact error:", err);
  }
}
