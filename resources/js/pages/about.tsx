import { Head } from '@inertiajs/react';
import { useState } from 'react';

export default function About() {
    const [count, setCount] = useState<number>(0);

    const resetCount = () => {
        setCount(0);
    };
    const handleIncrement = () => {
        setCount((prevCount) => prevCount + 1);
    };

    return(
        <>
            <div className="max-w-2xl px-3">
                <Head title="About" />
                <div id="background" className="p-8 sm:p-12 min-h-screen min-w-screen flex bg-linear-to-tr from-yellow-300 via-green-400 to-blue-500 justify-center items-center">
                    <div id="maincard" className="w-full max-w-6xl rounded-2xl shadow-2xl overflow-hidden px-6 py-8 sm:px-12 sm:py-12 bg-white">
                        <header className="">
                            <h1 className="font-bold text-3xl py-4 text-black">This is the About page.</h1>
                        </header>
                        <main>
                            <div className="py-3 text-black">
                                <p>This is the About page. It tells you what this website is about. This website is a URL Shortener built using Laravel, React, Inertia.js and Tailwind CSS.</p>
                            </div>
                            <div>
                                <section className="py-5">
                                    <div className="py-1 text-black">
                                        <p>Below is something completely unrelated that I designed:</p>
                                    </div>
                                    <div className="py-2 rounded-lg bg-linear-to-tr from-yellow-300 via-red-400 to-pink-400 p-4 text-center shadow-md">
                                        <h2 className="p-4 font-mono text-xl font-extrabold text-white">Here is a Story...</h2>
                                        <p className="rounded-tl-lg rounded-tr-lg bg-white p-3 text-left indent-8 font-mono font-bold text-teal-500">Once upon a time, there was a man named Harry. He found a mysterious green button on a screen. He pressed the button, and kept pressing it.</p>
                                        <div className="rounded-bl-lg rounded-br-lg bg-white py-1">
                                            <span className="font-mono font-bold text-teal-500"> He pressed the button: </span>
                                            <span id="counter" className="py-3 font-bold font-mono text-teal-500">{count}</span>
                                            <span className="w-2xl py-3 font-bold font-mono text-teal-500"> times</span>
                                        </div>
                                        <div id="buttons" className="py-4">
                                            <button onClick={handleIncrement}
                                            className="rounded-lg bg-green-500 px-4 py-2 text-sm font-medium text-white shadow transition hover:bg-green-600 active:scale-85">Press me :D</button>
                                            <button onClick={resetCount}
                                            className="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white shadow transition hover:bg-red-600 active:scale-85">Reset D:</button>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </>
    );
}
