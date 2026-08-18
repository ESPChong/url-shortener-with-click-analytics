// Learning Material

import { Head, Link } from '@inertiajs/react';

// Define the shape of the data coming from Laravel
interface PaginatedData {
  data: string[];       // Array of our items
  current_page: number; // The page we are currently on
  last_page: number;    // The final page number
}

export default function SimpleFaq({ paginatedData }: { paginatedData: PaginatedData }) {

  // Destructure the variables we need
  const { data, current_page, last_page } = paginatedData;

  return (
    <>
      <Head title="Simple Pagination" />

      <h2>Items on Page {current_page}:</h2>

      {/* 1. Loop through and display the data */}
      <ul>
        {data.map((item, index) => (
          <li key={index}>{item}</li>
        ))}
      </ul>

      {/* 2. Simple Pagination Controls */}
      <div style={{ marginTop: '20px' }}>

        {/* Previous Button: Only show as a link if we are NOT on page 1 */}
        {current_page > 1 ? (
          <Link href={`/v1/simplefaq?page=${current_page - 1}`}>Previous</Link>
        ) : (
          <span style={{ color: 'gray' }}>Previous</span>
        )}

        <span style={{ margin: '0 10px' }}>
          Page {current_page} of {last_page}
        </span>

        {/* Next Button: Only show as a link if we are NOT on the last page */}
        {current_page < last_page ? (
          <Link href={`/v1/simplefaq?page=${current_page + 1}`}>Next</Link>
        ) : (
          <span style={{ color: 'gray' }}>Next</span>
        )}

      </div>
    </>
  );
}
