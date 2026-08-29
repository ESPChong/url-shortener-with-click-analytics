import { Head } from '@inertiajs/react';

interface StatProps {
    total_shortens: number;
    shortens_today: number;
    total_clicks: number;
    clicks_today: number;
    avg_red_time: number;
}

export default function Dashboard({ stats } : { stats : StatProps }) {

    // Failsafe
    if (!stats) {
        return (
            <>
                <Head title="Dashboard" />
                <div className="min-h-screen flex items-center justify-center">
                    <p className="text-gray-500">Loading dashboard…</p>
                </div>
            </>
        );
    }

    const { total_shortens, shortens_today, total_clicks, clicks_today, avg_red_time } = stats;

    return (
        <>
            <Head title="Dashboard" />
            <div className="min-h-screen flex flex-col items-center justify-center bg-gray-50 p-4">
                <div className="w-full max-w-2xl bg-white p-8 rounded-lg shadow-md">
                    <h1 className="py-5 text-4xl font-bold mb-8 text-center text-gray-800">Click Analytics Engine</h1>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div className="p-4 bg-gray-50 rounded-lg text-center">
                            <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Links</h2>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{total_shortens}</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg text-center">
                            <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wider">Links Today</h2>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{shortens_today}</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg text-center">
                            <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Clicks</h2>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{total_clicks}</p>
                        </div>
                        <div className="p-4 bg-gray-50 rounded-lg text-center">
                            <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wider">Clicks Today</h2>
                            <p className="text-3xl font-bold text-gray-800 mt-2">{clicks_today}</p>
                        </div>
                        <div className="md:col-span-2 p-4 bg-indigo-50 rounded-lg text-center">
                            <h2 className="text-sm font-semibold text-indigo-500 uppercase tracking-wider">Avg Redirect Time</h2>
                            <p className="text-3xl font-bold text-indigo-600 mt-2">{avg_red_time} <span className="text-lg text-gray-500">ms</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
