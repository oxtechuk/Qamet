import { NavLink, useLocation } from "react-router-dom";
import { useLanguageStore } from "../store/language.store";
import type { IHeaderProps } from "../interfaces/IHeaderProps";
import Button from "./button";

function isActivePath(path: string, currentPath: string): boolean {
  if (path === "/") return currentPath === "/";
  return currentPath.startsWith(path);
}

export default function Header({
  logoSrc,
  logoAlt = "Logo",
  navItems,
  ctaText,
  ctaPath,
}: IHeaderProps) {
  const direction = useLanguageStore((s) => s.direction);
  const { pathname } = useLocation();

  return (
    <header className="w-full bg-[#F3F6F8] border-b border-[#d9e1e8]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div
          className="h-[70px] flex items-center justify-between gap-8"
          dir={direction}
        >
          {/* Logo */}
          <NavLink to="/" className="flex items-center shrink-0">
            <img
              src={logoSrc}
              alt={logoAlt}
              className="w-[70px] h-auto object-contain"
              loading="lazy"
            />
          </NavLink>

          {/* Navigation */}
          <nav className="hidden md:flex items-center justify-center gap-12 text-[#111827] text-lg font-medium">
            {navItems.map((item) => {
              const isActive = isActivePath(item.path, pathname);
              return (
                <NavLink
                  key={item.path}
                  to={item.path}
                  className={`transition ${isActive ? "active-nav-link" : "text-[#111827]"}`}
                  style={isActive ? { color: "var(--brand-primary-color)" } : undefined}
                >
                  {item.label}
                </NavLink>
              );
            })}
          </nav>

          {/* CTA Button */}
          <Button to={ctaPath}>{ctaText}</Button>
        </div>
      </div>
    </header>
  );
}
