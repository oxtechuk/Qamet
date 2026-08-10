# Skeleton Loading System — Prompt & Style Guide

A reusable guide for building skeleton (shimmer) loading UI that mirrors each page's real layout, the way it's done in this project. Use this document as a prompt for AI assistants or as a reference for developers when applying skeletons in other websites.

---

## 1. Philosophy

- Every data-driven page shows a **page-level skeleton** while its initial data loads — never a blank page, a spinner, or a centered "Loading…" text.
- The skeleton **mirrors the real page structure section by section** (hero, cards, grids, forms, etc.), using the same containers, gutters, grid columns, and spacing as the real components.
- Skeleton components are **composable**: shared card skeletons are reused across pages.
- Skeletons are **purely presentational** and animate a shimmer; they are never interactive and never fetch data.

---

## 2. Base components

### 2.1 `Skeleton` primitive

A single `<div>` that gets the shimmer styles + any Tailwind sizing/rounding passed via `className`.

```tsx
// components/Skeleton.tsx
interface ISkeletonProps {
  className?: string;
}

export default function Skeleton({ className = "" }: ISkeletonProps) {
  return <div aria-hidden="true" className={`skeleton ${className}`} />;
}
```

Use Tailwind arbitrary values for exact sizing and rounding, e.g.:

```tsx
<Skeleton className="h-[52px] w-full rounded-[10px]" />
<Skeleton className="h-9 w-72 md:w-96" />          // h-9 = 36px
<Skeleton className="h-[40px] w-24 rounded-full" /> // pill
<Skeleton className="h-8 w-8 rounded-full" />       // avatar
<Skeleton className="h-px flex-1" />                // divider
```

### 2.2 Shimmer CSS

The whole system depends on ONE css class. Put it in the global stylesheet (must be **unlayered** — see note below).

```css
.skeleton {
  background: linear-gradient(90deg, #e8ecf1 25%, #f4f7fa 50%, #e8ecf1 75%);
  background-size: 200% 100%;
  animation: lazy-img-shimmer 1.5s ease-in-out infinite;
}

@keyframes lazy-img-shimmer {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}
```

> **IMPORTANT:** `.skeleton` sets the `background` **shorthand**, so utility classes like `bg-white/20` will NOT override it (unlayered CSS wins over utility layers). To change the bar color, edit the gradient in `.skeleton` itself, or use inline `style`. Keep all skeleton bars the same light-gray shimmer.

---

## 3. Colors & style rules

### 3.1 Shimmer palette (the bars)

| Token | Value | Use |
|---|---|---|
| bar base | `#e8ecf1` | main skeleton bar color |
| bar highlight | `#f4f7fa` | shimmer sweep highlight |
| animation | `1.5s ease-in-out infinite` | speed & easing |

### 3.2 Neutral backgrounds (allowed on skeleton sections)

Gray/off-white section backgrounds are used so the skeleton reads like the real page. **Never use brand/colored backgrounds.**

| Token | Value | Typical use |
|---|---|---|
| section bg (light cream) | `#FAFAF8` | light sections (contact methods, about) |
| section bg (warm gray) | `#F9F9F7` | FAQ / footer-ish sections |
| section bg (cool gray) | `#EDEFF3` | hero sections |
| hero block bg | `#E2E6EC` | inside a gray hero, behind bars |
| card bg | `white` | cards, panels, forms |
| card border | `#E5E7EB` | card outlines |
| inner border / separators | `#F3F4F6`, `#F0F2F5`, `#E2E2DE` | dividers inside cards |

### 3.3 Radii (match the real components)

| Shape | Radius |
|---|---|
| inputs / small buttons | `rounded-[10px]` / `rounded-[12px]` |
| card corners | `rounded-[16px]` / `rounded-[18px]` / `rounded-[20px]` |
| hero blocks | `rounded-[18px]` / `rounded-[24px]` / `rounded-[32px]` |
| pills, badges, avatars | `rounded-full` |

### 3.4 Proportions (approx the real text)

| Real element | Skeleton size |
|---|---|
| page title (h1/h2) | `h-9` → `h-[44px]` (md: wider) |
| section heading | `h-7` / `h-8` / `h-9` |
| paragraph line | `h-4` |
| small label | `h-3` |
| primary button | `h-[44px]` / `h-[48px]` / `h-[52px]` `rounded-2xl` |
| avatar | `h-8 w-8` → `h-12 w-12` `rounded-full` |
| image placeholder | same height/width as real image, `rounded-none` inside a clipped container |

---

## 4. Conventions for building a PageSkeleton

1. Root wrapper:
   ```tsx
   <div aria-busy="true" aria-label="Loading <page> page" className="w-full select-none">
   ```
   (`select-none` prevents text selection jank during load.)

2. Replicate the real page **from top to bottom**: hero → filter/tabs → grid → pagination → footer CTA. Copy the real section's container classes (`max-w-*`, `px-*`, `py-*`, `grid-cols-*`, `gap-*`) so the skeleton swaps in without layout shift.

3. Compose shared sub-skeletons instead of repeating markup:
   - `SectionHeaderSkeleton` (title + action button row)
   - `CarsGridSkeleton` / `CarCardSkeleton`
   - `BlogCardSkeleton`
   - `OfferListCardSkeleton`

4. For card grids, render the same count as the real first screen (e.g., 6 for a 3-col grid), each using the shared card skeleton.

5. Use comments with `── section name ──` to label blocks.

### Example: shared card skeleton

```tsx
// components/skeletons/BlogCardSkeleton.tsx
import Skeleton from "../Skeleton";

export default function BlogCardSkeleton() {
  return (
    <article className="block w-full overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm">
      <div className="relative h-[220px] w-full overflow-hidden">
        <Skeleton className="h-full w-full rounded-none" />
        <Skeleton className="absolute start-3 top-3 h-7 w-20 rounded-full" />
      </div>
      <div className="px-4 pb-5 pt-4">
        <Skeleton className="h-4 w-16" />
        <Skeleton className="mt-3 h-5 w-full" />
        <Skeleton className="mt-2 h-5 w-3/4" />
        <Skeleton className="mt-3 h-4 w-full" />
        <Skeleton className="mt-2 h-4 w-2/3" />
        <div className="mt-4 flex items-center gap-3 border-t border-[#F3F4F6] pt-4">
          <Skeleton className="h-[40px] w-[40px] rounded-full" />
          <Skeleton className="h-4 w-24" />
        </div>
      </div>
    </article>
  );
}
```

### Example: page skeleton

```tsx
// components/skeletons/BlogsPageSkeleton.tsx
import Skeleton from "../Skeleton";
import BlogCardSkeleton from "./BlogCardSkeleton";

export default function BlogsPageSkeleton() {
  return (
    <div aria-busy="true" aria-label="Loading blog page" className="w-full select-none">
      {/* ── Hero ── */}
      <section className="w-full bg-[#EDEFF3] py-5 sm:py-7 lg:py-8">
        <div className="mx-auto max-w-[1440px] px-4 sm:px-6 lg:px-8">
          <div className="relative min-h-[285px] w-full overflow-hidden rounded-[18px] bg-[#E2E6EC]">
            <div className="flex min-h-[285px] flex-col justify-between px-5 py-5 sm:px-8 sm:py-7 lg:px-12 lg:py-10">
              <Skeleton className="h-[30px] w-24 rounded-full" />
              <div className="max-w-[900px] self-start text-start">
                <Skeleton className="mb-3 h-3 w-28 rounded-full" />
                <Skeleton className="h-[28px] w-full max-w-[700px] sm:h-[38px] lg:h-[44px]" />
                <Skeleton className="mt-2 h-[28px] w-3/4 max-w-[520px] sm:h-[38px] lg:h-[44px]" />
                <Skeleton className="mt-4 h-4 w-full max-w-[760px]" />
                <div className="mt-5 flex flex-wrap items-center gap-x-5 gap-y-3">
                  <Skeleton className="h-4 w-28" />
                  <Skeleton className="h-4 w-20" />
                  <Skeleton className="h-4 w-24" />
                </div>
              </div>
            </div>
          </div>

          {/* ── Category pills ── */}
          <div className="mt-7 flex flex-wrap items-start justify-start gap-3">
            {Array.from({ length: 5 }).map((_, i) => (
              <Skeleton key={i} className="h-[40px] w-24 rounded-full" />
            ))}
          </div>
        </div>
      </section>

      {/* ── Latest articles ── */}
      <section className="w-full py-14">
        <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 gap-x-10 gap-y-14 md:grid-cols-2 lg:grid-cols-3">
            {Array.from({ length: 6 }).map((_, i) => (
              <BlogCardSkeleton key={i} />
            ))}
          </div>
          <div className="mt-12 flex justify-center">
            <Skeleton className="h-[42px] w-52 rounded-full" />
          </div>
        </div>
      </section>
    </div>
  );
}
```

---

## 5. Wiring the skeleton into a page (React Query)

### 5.1 Replace text loading with the page skeleton

```tsx
const { data, isPending } = useQuery({ queryKey, queryFn });

if (isPending) {
  return <PageSkeleton />;
}
```

### 5.2 Avoid flash on pagination / filter changes

For queries whose `queryKey` changes on page/filter state, use `keepPreviousData` so the skeleton only appears on **first load** (the previous data stays visible while the new page fetches):

```tsx
import { keepPreviousData, useQuery } from "@tanstack/react-query";

const { data, isPending } = useQuery({
  queryKey: ["offers", language, page],
  queryFn: () => getOffers(page, 12),
  placeholderData: keepPreviousData,
});

if (isPending) return <OffersPageSkeleton />;
```

### 5.3 Use the page skeleton as the router Suspense fallback

For lazy-loaded routes, the Suspense fallback should be the page skeleton (NOT a generic spinner), so the skeleton covers both the JS-chunk download and the data fetch:

```tsx
import { lazy, Suspense } from "react";
import OffersPageSkeleton from "../components/skeletons/OffersPageSkeleton";

const OffersPage = lazy(() => import("../pages/OffersPage"));

// in the router:
{
  path: "/offers",
  element: (
    <Suspense fallback={<OffersPageSkeleton />}>
      <OffersPage />
    </Suspense>
  ),
}
```

---

## 6. Checklist

- [ ] `Skeleton` primitive + `.skeleton` shimmer CSS exist once in the project.
- [ ] No spinners, blank pages, or "Loading…" text on any data-driven page.
- [ ] Every lazy route's Suspense fallback is a skeleton (not a spinner).
- [ ] Page skeleton mirrors the real page: same containers, gutters, grid columns, gaps, heights, radii.
- [ ] Shared card skeletons reused (no duplicated markup).
- [ ] `aria-busy="true"` + `aria-label` + `select-none` on the skeleton root.
- [ ] Only neutral gray backgrounds (`#EDEFF3`, `#E2E6EC`, `#FAFAF8`, `#F9F9F7`, white) — no brand colors.
- [ ] `keepPreviousData` used where the query key changes with page/filter state.
- [ ] TypeScript + build pass after adding skeletons.

---

## 7. Reusable prompt

> Build a skeleton loading system for our app. Create a reusable `Skeleton` component that renders a `<div aria-hidden="true" className="skeleton ...">` and add this CSS once: `.skeleton { background: linear-gradient(90deg, #e8ecf1 25%, #f4f7fa 50%, #e8ecf1 75%); background-size: 200% 100%; animation: lazy-img-shimmer 1.5s ease-in-out infinite; }` with a matching `lazy-img-shimmer` keyframe shifting background-position from 200% to -200%.
>
> For every data-driven page, build a `<XxxPageSkeleton>` that mirrors the real page's layout section by section (same max-widths, padding, grid columns, gaps, card sizes, border radii). Cards in grids must use shared card skeletons. Use only neutral gray/white backgrounds — never brand colors — e.g. `#EDEFF3`, `#E2E6EC`, `#FAFAF8`, `#F9F9F7`, `white` cards with `#E5E7EB` borders. Approximate text heights (h-3 labels, h-4 lines, h-7–h-9 headings, h-[44px]–h-[52px] buttons) and use `rounded-[10px]–[32px]` and `rounded-full` to match the design.
>
> Wrap each skeleton root in `<div aria-busy="true" aria-label="Loading ..." className="w-full select-none">`.
>
> Wire it in: gate each page's data query with `if (isPending) return <XxxPageSkeleton />`. Where a query key changes on page/filter state, add `placeholderData: keepPreviousData` so the skeleton only flashes on the first load. In the router, use each lazy route's `<XxxPageSkeleton>` as its `<Suspense fallback>` instead of a spinner.
