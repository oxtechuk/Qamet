export function getLocalizedName(
  name: unknown,
  lang: string = "ar",
): string {
  if (!name) return "";
  if (typeof name === "string") return name;
  if (typeof name === "object" && name !== null) {
    const record = name as Record<string, unknown>;
    const short = (lang || "ar").slice(0, 2).toLowerCase();
    const val = record[lang] ?? record[short] ?? record["ar"] ?? record["en"] ?? Object.values(record)[0];
    return typeof val === "string" ? val : (val ? String(val) : "");
  }
  return String(name);
}
