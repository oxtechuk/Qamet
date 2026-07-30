import type { BlogApiResponse, BlogDetailsApiResponse, BlogDetails } from "../../types/blogs.types";
import api from "./http";

export async function getBlogs(
  page = 1,
  perPage = 6
): Promise<BlogApiResponse> {
  const response = await api.get<BlogApiResponse>("store/blog", {
    params: { page, per_page: perPage },
  });
  return response.data;
}

export async function getBlogBySlug(slug: string): Promise<BlogDetails> {
  const response = await api.get<BlogDetailsApiResponse>(`store/blog/${slug}`);
  return response.data.data;
}
