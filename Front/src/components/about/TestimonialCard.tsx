import type { ITestimonialItem } from "../../interfaces/ITestimonialItem";
import RatingStars from "./RatingStars";

export default function TestimonialCard({
  testimonial,
}: {
  testimonial: ITestimonialItem & { isActive?: boolean };
}) {
  const isActive = testimonial.isActive;

  return (
    <article
      className={`flex min-h-[220px] flex-col justify-between rounded-3xl border p-8 transition-all duration-300 ${
        isActive
          ? "scale-105 border-[#111722] bg-[#111722] text-white shadow-[0_18px_45px_rgba(15,23,42,0.18)]"
          : "border-[#D9DEE7] bg-white text-[#111827] shadow-sm"
      }`}
    >
      <div>
        <div className="mb-7 flex justify-end">
          <RatingStars />
        </div>

        <p
          className={`text-start text-[15px] leading-8 ${
            isActive ? "text-white/90" : "text-[#1F2937]"
          }`}
        >
          &ldquo;{testimonial.text}&rdquo;
        </p>
      </div>

      <div
        className={`mt-7 border-t pt-4 ${
          isActive ? "border-white/15" : "border-[#E5E7EB]"
        }`}
      >
        <div className="flex items-center justify-start gap-4">
          <div className="text-start">
            <h3
              className={`font-extrabold ${
                isActive ? "text-white" : "text-[#111827]"
              }`}
            >
              {testimonial.name}
            </h3>

            <p
              className={`mt-1 text-sm ${
                isActive ? "text-white/50" : "text-[#6B7280]"
              }`}
            >
              {testimonial.job}
            </p>
          </div>

          <img
            src={testimonial.avatar}
            alt={testimonial.name}
            className="h-12 w-12 rounded-full object-cover ring-4 ring-[#E8EEF5]"
            loading="lazy"
          />
        </div>
      </div>
    </article>
  );
}
