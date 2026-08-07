import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function About() {
    const [count, setCount] = useState<number>(0);

    const resetCount = () => setCount(0);
    const handleIncrement = () => setCount((prevCount) => prevCount + 1);

    return(
        <>
            <Head title="About" />
            <div className="min-h-screen p-8 sm:p-12 flex bg-linear-to-tr from-yellow-300 via-green-400 to-blue-500 justify-center items-center">
                <div className="w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden px-6 py-8 sm:px-12 sm:py-12 bg-white">
                    <header>
                        <h1 className="font-extrabold text-3xl py-4 text-black">
                            This is the About page.
                        </h1>
                    </header>
                    <main>
                        <p className="py-3 text-black">
                            This is the About page. It tells you what this website is about. This website is a URL Shortener built using Laravel, React, Inertia.js and Tailwind CSS.
                        </p>
                        <div>
                            <p className="py-5 text-black">
                                Below is something completely unrelated that I designed:
                            </p>
                            <div className="rounded-lg bg-linear-to-tr from-yellow-300 via-red-400 to-pink-400 p-4 text-center shadow-lg">
                                <h2 className="p-4 font-mono text-xl font-extrabold text-white">
                                    Here is a Story...
                                </h2>
                                <p className="rounded-lg bg-white p-3 text-left indent-8 font-mono font-bold text-teal-500 shadow-lg">
                                    Once upon a time, there was a man named Harry. He found a mysterious green button on a screen. He pressed the button, and kept pressing it. He pressed the button: {count} times.
                                </p>
                                <div className="py-4 flex justify-center gap-4">
                                    <button
                                    type="button"
                                    onClick={handleIncrement}
                                    className="rounded-lg text-sm font-medium text-white bg-green-500 px-4 py-2 shadow transition hover:bg-green-600 active:scale-95">Press me :D</button>
                                    <button
                                    type="button"
                                    onClick={resetCount}
                                    className="rounded-lg text-sm font-medium text-white bg-red-500 px-4 py-2 shadow transition hover:bg-red-600 active:scale-95">Reset D:</button>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </>
    );
}
