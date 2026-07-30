export interface BlogEmployee {
  name: string;
  role: string;
  avatar: string | null;
}

export interface BlogCategory {
  id: number;
  name: string;
  slug: string;
  icon: string | null;
  sort_order: number;
  posts_count?: number;
}

export interface BlogPost {
  id: number;
  title: string;
  slug: string;
  thumbnail: string | null;
  excerpt: string;
  published_at: string;
  employee: BlogEmployee;
  categories: BlogCategory[];
  reading_time: number;
}

export interface BlogDetails extends BlogPost {
  content: string;
  meta_title: string | null;
  meta_description: string | null;
  meta_keywords: string | null;
  is_featured: boolean;
  related_posts: BlogPost[];
}

export interface BlogHero {
  title: string;
  subtitle: string;
  image: string | null;
  badge?: string;
}

export interface BlogMeta {
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
  hero: BlogHero;
  featured_posts: BlogPost[];
  categories: BlogCategory[];
}

export interface BlogApiResponse {
  success: boolean;
  message: string;
  data: BlogPost[];
  errors: null;
  meta: BlogMeta;
}

export interface BlogDetailsApiResponse {
  success: boolean;
  message: string;
  data: BlogDetails;
  errors: null;
  meta: null;
}
