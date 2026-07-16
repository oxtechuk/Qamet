export function toEmbedUrl(url: string): string {
  if (!url) return "";

  if (url.includes("/maps/embed")) return url;

  if (url.includes("goo.gl") || url.includes("maps.app")) return url;

  if (url.includes("/maps/place/")) {
    const coords = url.match(/@(-?\d+\.?\d*),(-?\d+\.?\d*)/);
    if (coords) {
      return `https://www.google.com/maps?q=${coords[1]},${coords[2]}&output=embed`;
    }
    const place = url.match(/\/maps\/place\/([^@/?]+)/);
    if (place) {
      return `https://www.google.com/maps?q=${encodeURIComponent(place[1].replace(/\+/g, " "))}&output=embed`;
    }
  }

  return `https://www.google.com/maps?output=embed&q=${encodeURIComponent(url)}`;
}
