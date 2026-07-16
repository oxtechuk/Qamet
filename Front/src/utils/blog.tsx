import { getImageUrl } from "../constants/app-images";
import type { BlogPost } from "../types/blogs.types";
import type { IBlogArticleSection } from "../interfaces/IBlogArticleContentProps";

export function formatBlogDate(iso: string, language: string): string {
  const date = new Date(iso);
  const locale = language === "ar" ? "ar-SA" : "en-US";
  return date.toLocaleDateString(locale, {
    year: "numeric",
    month: "long",
    day: "numeric",
  });
}

export function formatBlogReadTime(minutes: number, language: string): string {
  if (language === "ar") {
    if (minutes < 1) return "أقل من دقيقة";
    if (minutes === 1) return "دقيقة واحدة";
    if (minutes === 2) return "دقيقتان";
    return `${minutes} دقائق`;
  }
  return `${minutes} min read`;
}

export function postToCardProps(
  post: BlogPost,
  language: string,
  t: (key: string) => string
) {
  return {
    id: post.id,
    image: getImageUrl(post.thumbnail) || "/images/blog.png",
    category:
      post.categories.map((c) => c.name).join(", ") ||
      t("blogPage.hero.featuredPost.category"),
    date: formatBlogDate(post.published_at, language),
    readTime: formatBlogReadTime(post.reading_time, language),
    title: post.title || t("blogPage.hero.featuredPost.title"),
    description: post.excerpt || t("blogPage.hero.featuredPost.description"),
    authorName:
      post.employee.name || t("blogPage.hero.featuredPost.author.name"),
    authorRole:
      post.employee.role || t("blogPage.hero.featuredPost.author.role"),
    authorImage:
      getImageUrl(post.employee.avatar) || "/images/blogs/author.png",
    readMoreTo: `/blog/${post.slug}`,
  };
}

export function parseBlogContent(
  content: string
): IBlogArticleSection[] {
  const blocks = content.split(/\r?\n\r?\n/).filter(Boolean);
  const sections: IBlogArticleSection[] = [];
  let currentSection: IBlogArticleSection | null = null;

  for (const block of blocks) {
    const lines = block.split(/\r?\n/).filter(Boolean);
    const firstLine = lines[0].trim();
    const isTitle =
      /^\d+\.\s/.test(firstLine) ||
      (/^[^.!?]{1,30}:\s*$/.test(firstLine) && lines.length > 0);

    if (isTitle) {
      currentSection = {
        title: firstLine,
        highlight: true,
        paragraphs: [],
        list: [],
      };
      for (let i = 1; i < lines.length; i++) {
        currentSection.paragraphs.push(lines[i].trim());
      }
      sections.push(currentSection);
    } else if (currentSection) {
      if (lines.length > 1) {
        if (!currentSection.list) currentSection.list = [];
        currentSection.list.push(...lines.map((l) => l.trim()));
      } else {
        currentSection.paragraphs.push(firstLine);
      }
    } else {
      currentSection = { paragraphs: lines.map((l) => l.trim()) };
      sections.push(currentSection);
    }
  }

  return sections;
}
