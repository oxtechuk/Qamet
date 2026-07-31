export function getLocalizedName(
  name: string | Record<string, string> | undefined,
  lang: string,
): string {
  if (!name) return "";
  if (typeof name === "string") return name;
  return name[lang] ?? name["en"] ?? "";
}
