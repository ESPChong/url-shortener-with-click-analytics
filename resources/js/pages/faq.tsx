import { Head, Link } from '@inertiajs/react';
import { Fragment } from 'react';

// 1. Define the shape of a single FAQ item
interface FaqItem {
  id: number;
  question: string;
  answer: string;
}

// 2. Define the shape of the Laravel pagination object
interface PaginatedFaqs {
  data: FaqItem[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
}

// 3. Apply the types to component props
export default function Faq({ faqs }: { faqs: PaginatedFaqs }) {
  const { data, current_page, last_page, per_page } = faqs;

  return (
    <>
      <Head title="FAQ" />
      <p className="font-mono font-bold text-5xl mt-2 mb-10">
        This is an FAQ page.
      </p>

      <ul className="w-200 text-sm font-medium text-heading bg-linear-to-br from-yellow-300 via-amber-500 to-red-600 border border-default rounded-base">
        {/* faq and index are now automatically typed based on the FaqItem[] array */}
        {data.map((faq, index) => {
          // Global numbering so item 6 on page 2 still says "6."
          const globalIndex = (current_page - 1) * per_page + index + 1;

          return (
            <Fragment key={faq.id || index}>
              <li className="w-full px-4 py-2 border-l-8 border-l-red-500 border-b text-black">
                {globalIndex}. {faq.question}
              </li>
              <li className="indent-4 w-full px-4 py-2 border-b border-default text-black">
                - {faq.answer}
              </li>
            </Fragment>
          );
        })}
      </ul>

      {/* Pagination nav */}
      <nav aria-label="FAQ pagination" className="mt-6">
        <ul className="flex -space-x-px text-sm">
          {/* Previous */}
          <li>
            {current_page > 1 ? (
              <Link
                href={`/faq?page=${current_page - 1}`}
                className="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-s-base text-sm px-3 h-10 focus:outline-none"
              >
                Previous
              </Link>
            ) : (
              <span className="flex items-center justify-center text-body/50 bg-neutral-secondary-medium box-border border border-default-medium font-medium rounded-s-base text-sm px-3 h-10 cursor-not-allowed">
                Previous
              </span>
            )}
          </li>

          {/* Page numbers */}
          {Array.from({ length: last_page }, (_, i) => i + 1).map((n) => (
            <li key={n}>
              <Link
                href={`/faq?page=${n}`}
                aria-current={current_page === n ? 'page' : undefined}
                className={
                  'flex items-center justify-center box-border border border-default-medium font-medium text-sm w-10 h-10 focus:outline-none ' +
                  (current_page === n
                    ? 'text-fg-brand bg-neutral-tertiary-medium hover:text-fg-brand'
                    : 'text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary-medium hover:text-heading')
                }
              >
                {n}
              </Link>
            </li>
          ))}

          {/* Next */}
          <li>
            {current_page < last_page ? (
              <Link
                href={`/faq?page=${current_page + 1}`}
                className="flex items-center justify-center text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading font-medium rounded-e-base text-sm px-3 h-10 focus:outline-none"
              >
                Next
              </Link>
            ) : (
              <span className="flex items-center justify-center text-body/50 bg-neutral-secondary-medium box-border border border-default-medium font-medium rounded-e-base text-sm px-3 h-10 cursor-not-allowed">
                Next
              </span>
            )}
          </li>
        </ul>
      </nav>
    </>
  );
}
