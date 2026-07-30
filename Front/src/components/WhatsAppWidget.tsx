import { useSettingsStore } from "../store/settings.store";
import { useLanguageStore } from "../store/language.store";

export default function WhatsAppWidget() {
  const { settings, loaded } = useSettingsStore();
  const direction = useLanguageStore((s) => s.direction);
  const language = useLanguageStore((s) => s.language);

  if (!loaded || !settings?.contact?.whatsapp) {
    return null;
  }

  // Format whatsapp number to ensure it works with the WhatsApp api
  const rawPhone = settings.contact.whatsapp.replace(/\D/g, "");
  const whatsappUrl = `https://api.whatsapp.com/send?phone=${rawPhone}`;

  const tooltipText = language === "ar" ? "تواصل معنا عبر واتساب" : "Contact us on WhatsApp";

  return (
    <div
      className={`fixed z-50 transition-all duration-300 ${
        direction === "rtl" ? "left-6 md:left-8" : "right-6 md:right-8"
      } bottom-24 md:bottom-8`}
    >
      {/* Pulse Ring */}
      <span className="absolute -inset-1 rounded-full bg-[#25D366] opacity-40 animate-ping pointer-events-none"></span>

      {/* Button */}
      <a
        href={whatsappUrl}
        target="_blank"
        rel="noopener noreferrer"
        className="group relative flex items-center justify-center w-14 h-14 bg-[#25D366] rounded-full shadow-lg hover:bg-[#20ba5a] transition-all duration-300 hover:scale-110 active:scale-95"
        title={tooltipText}
      >
        {/* SVG WhatsApp Icon */}
        <svg
          className="w-8 h-8 text-white fill-current"
          viewBox="0 0 24 24"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.96 9.96 0 001.333 4.993L2 22l5.13-1.343a9.96 9.96 0 004.882 1.28h.003c5.502 0 9.988-4.478 9.99-9.988A9.97 9.97 0 0012.012 2zm5.748 13.917c-.297.836-1.558 1.536-2.114 1.61-.486.066-1.12.124-3.238-.752-2.705-1.118-4.433-3.864-4.568-4.047-.13-.183-1.07-1.423-1.07-2.71 0-1.286.674-1.92.915-2.176.244-.256.529-.32.707-.32a.59.59 0 01.42.2c.162.24.55 1.353.598 1.45.048.098.082.213.017.34-.066.13-.1.215-.2.32-.098.11-.2.246-.285.348-.1.112-.2.234-.085.43.113.197.5.828 1.076 1.34.744.662 1.37.868 1.564.965.197.1.312.083.43-.05.118-.133.513-.598.65-.8a.56.56 0 01.416-.25c.163-.017.973.46.1.528s.229.479.375.568c.148.09.245.048.343-.098.098-.146.488-.686.785-1.522z" />
        </svg>

        {/* Text Tooltip */}
        <span
          className={`absolute hidden md:group-hover:inline-block bg-[#1f2937] text-white text-xs font-semibold px-3 py-2 rounded-lg shadow-md whitespace-nowrap -top-12 transition-all duration-300`}
        >
          {tooltipText}
        </span>
      </a>
    </div>
  );
}
