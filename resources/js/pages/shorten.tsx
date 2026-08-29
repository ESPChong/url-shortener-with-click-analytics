import { Head, useForm } from '@inertiajs/react';
import { useState } from 'react';
import type { ChangeEvent, SyntheticEvent } from 'react';

export default function Shorten() {
    const [shortenedUrl, setShortenedUrl] = useState<string | null>(null);

    const { data, setData, post, processing, errors } = useForm<{ long_url: string }>({
        long_url: '',
    });

    const submit = (e: SyntheticEvent) => {
        e.preventDefault();
        post('/shorten', {
            preserveScroll: true,
            onSuccess: (page) => {
                const props = page.props as unknown as { shortUrl?: string };

                if (props.shortUrl) {
                    setShortenedUrl(props.shortUrl);
                }
            },
            onError: (errors) => {
                // If validation fails or the server crashes, it comes here.
                console.error("Submission failed. Errors:", errors);
            }
        });
    };

    const handleChange = (e: ChangeEvent<HTMLInputElement>) => {
        setData('long_url', e.target.value);

        if (shortenedUrl) {
            setShortenedUrl(null);
        }
    };

    // Note: If your backend returns a FULL URL (e.g., http://localhost/r/abc),
    // you should change this to just: `const redirectUrl = shortenedUrl;`
    const redirectUrl = shortenedUrl ? `/r/${shortenedUrl}` : null;

    return (
        <>
            <Head title="Shorten URL" />

            <div className="min-h-screen flex flex-col items-center justify-center bg-gray-50 p-4">
                <div className="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
                    <h1 className="text-2xl font-bold mb-6 text-center text-gray-800">URL Shortener</h1>

                    <form onSubmit={submit} className="space-y-4">
                        <input
                            type="url"
                            value={data.long_url}
                            onChange={handleChange}
                            placeholder="Enter your long URL here"
                            className="w-full px-4 py-2 border border-gray-300 text-black rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        />
                        {errors.long_url && <p className="text-red-500 text-sm">{errors.long_url}</p>}

                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                        >
                            {processing ? 'Shortening...' : 'Shorten'}
                        </button>
                    </form>

                    {redirectUrl && (
                        <div className="mt-6 p-4 bg-green-50 rounded-md text-center">
                            <p className="text-sm text-gray-600">Your shortened URL:</p>
                            <a
                                href={"http://127.0.0.1:8000"+redirectUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="text-indigo-600 font-semibold break-all hover:underline"
                            >
                                {redirectUrl}
                            </a>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}
