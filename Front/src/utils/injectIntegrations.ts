import type { IIntegrationsInfo } from "../interfaces/ISettingsData";

const INJECTED_TAG_ATTRIBUTE = "data-qamet-dynamic-integration";

/**
 * Dynamically inject tracking pixels & third-party scripts based on admin settings
 */
export function injectIntegrations(integrations?: IIntegrationsInfo): void {
  if (!integrations || typeof window === "undefined") return;

  const {
    gtm_id,
    google_analytics_id,
    facebook_pixel_id,
    snapchat_pixel_id,
    tiktok_pixel_id,
    twitter_pixel_id,
    header_scripts,
    body_scripts,
  } = integrations;

  // 1. Google Tag Manager (GTM)
  if (gtm_id && gtm_id.trim().startsWith("GTM-")) {
    const cleanGtmId = gtm_id.trim();
    if (!document.getElementById("qamet-gtm-script")) {
      const gtmScript = document.createElement("script");
      gtmScript.id = "qamet-gtm-script";
      gtmScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "gtm");
      gtmScript.innerHTML = `(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','${cleanGtmId}');`;
      document.head.appendChild(gtmScript);
    }
  }

  // 2. Google Analytics GA4
  if (google_analytics_id && google_analytics_id.trim().length > 3) {
    const cleanGaId = google_analytics_id.trim();
    if (!document.getElementById("qamet-ga4-script")) {
      const gaScript = document.createElement("script");
      gaScript.id = "qamet-ga4-script";
      gaScript.async = true;
      gaScript.src = `https://www.googletagmanager.com/gtag/js?id=${cleanGaId}`;
      gaScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "ga4");
      document.head.appendChild(gaScript);

      const gaInitScript = document.createElement("script");
      gaInitScript.id = "qamet-ga4-init";
      gaInitScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "ga4-init");
      gaInitScript.innerHTML = `
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '${cleanGaId}');`;
      document.head.appendChild(gaInitScript);
    }
  }

  // 3. Meta / Facebook Pixel
  if (facebook_pixel_id && facebook_pixel_id.trim().length > 3) {
    const cleanFbId = facebook_pixel_id.trim();
    const basePixelEl = document.getElementById("qamet-fb-pixel-base");
    const dynamicPixelEl = document.getElementById("qamet-fb-pixel");

    if (!basePixelEl && !dynamicPixelEl) {
      // No pixel at all — inject fully
      const fbScript = document.createElement("script");
      fbScript.id = "qamet-fb-pixel";
      fbScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "fb");
      fbScript.innerHTML = `!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '${cleanFbId}');
fbq('track', 'PageView');`;
      document.head.appendChild(fbScript);
    } else if (typeof window.fbq === "function") {
      // fbq already loaded (from index.html or previous inject) — only add new pixel ID if different
      const alreadyInitScript = document.getElementById("qamet-fb-pixel-init-" + cleanFbId);
      if (!alreadyInitScript) {
        const initScript = document.createElement("script");
        initScript.id = "qamet-fb-pixel-init-" + cleanFbId;
        initScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "fb-extra-init");
        initScript.innerHTML = `fbq('init', '${cleanFbId}');`;
        document.head.appendChild(initScript);
      }
    }
  }

  // 4. TikTok Pixel
  if (tiktok_pixel_id && tiktok_pixel_id.trim().length > 3) {
    const cleanTtId = tiktok_pixel_id.trim();
    if (!document.getElementById("qamet-tiktok-pixel")) {
      const ttScript = document.createElement("script");
      ttScript.id = "qamet-tiktok-pixel";
      ttScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "tiktok");
      ttScript.innerHTML = `!function (w, d, t) {
w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
ttq.load('${cleanTtId}');
ttq.page();
}(window, document, 'ttq');`;
      document.head.appendChild(ttScript);
    }
  }

  // 5. Snapchat Pixel
  if (snapchat_pixel_id && snapchat_pixel_id.trim().length > 3) {
    const cleanSnapId = snapchat_pixel_id.trim();
    if (!document.getElementById("qamet-snap-pixel")) {
      const snapScript = document.createElement("script");
      snapScript.id = "qamet-snap-pixel";
      snapScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "snap");
      snapScript.innerHTML = `(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()
{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};
a.queue=[];var s='script';r=t.createElement(s);r.async=!0;
r.src=n;var u=t.getElementsByTagName(s)[0];
u.parentNode.insertBefore(r,u);})(window,document,
'https://sc-static.net/scevent.min.js');
snaptr('init', '${cleanSnapId}');
snaptr('track', 'PAGE_VIEW');`;
      document.head.appendChild(snapScript);
    }
  }

  // 6. Twitter / X Pixel
  if (twitter_pixel_id && twitter_pixel_id.trim().length > 2) {
    const cleanTwId = twitter_pixel_id.trim();
    if (!document.getElementById("qamet-twitter-pixel")) {
      const twScript = document.createElement("script");
      twScript.id = "qamet-twitter-pixel";
      twScript.setAttribute(INJECTED_TAG_ATTRIBUTE, "twitter");
      twScript.innerHTML = `!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='https://static.ads-twitter.com/uwt.js',
a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
twq('config','${cleanTwId}');`;
      document.head.appendChild(twScript);
    }
  }

  // 7. Custom Header Scripts
  if (header_scripts && header_scripts.trim().length > 0) {
    if (!document.getElementById("qamet-custom-header-scripts")) {
      const container = document.createElement("div");
      container.id = "qamet-custom-header-scripts";
      container.setAttribute(INJECTED_TAG_ATTRIBUTE, "custom-header");
      container.innerHTML = header_scripts;

      // Extract scripts to execute inline scripts properly
      Array.from(container.children).forEach((child) => {
        if (child.tagName === "SCRIPT") {
          const scriptEl = document.createElement("script");
          Array.from(child.attributes).forEach((attr) =>
            scriptEl.setAttribute(attr.name, attr.value)
          );
          scriptEl.innerHTML = child.innerHTML;
          document.head.appendChild(scriptEl);
        } else {
          document.head.appendChild(child.cloneNode(true));
        }
      });
    }
  }

  // 8. Custom Body Scripts
  if (body_scripts && body_scripts.trim().length > 0) {
    if (!document.getElementById("qamet-custom-body-scripts")) {
      const container = document.createElement("div");
      container.id = "qamet-custom-body-scripts";
      container.setAttribute(INJECTED_TAG_ATTRIBUTE, "custom-body");
      container.innerHTML = body_scripts;

      Array.from(container.children).forEach((child) => {
        if (child.tagName === "SCRIPT") {
          const scriptEl = document.createElement("script");
          Array.from(child.attributes).forEach((attr) =>
            scriptEl.setAttribute(attr.name, attr.value)
          );
          scriptEl.innerHTML = child.innerHTML;
          document.body.appendChild(scriptEl);
        } else {
          document.body.appendChild(child.cloneNode(true));
        }
      });
    }
  }
}
