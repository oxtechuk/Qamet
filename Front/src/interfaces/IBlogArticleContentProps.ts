export interface IBlogArticleSection {
  title?: string;
  paragraphs: string[];
  list?: string[];
  highlight?: boolean;
}

export interface IBlogArticleContentProps {
  sections: IBlogArticleSection[];
}
