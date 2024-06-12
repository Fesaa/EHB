import {createRoot} from "react-dom/client";
// @ts-ignore
import React, {Component} from "react";

type LoginProps = {}

type LoginState = {}

class Login extends Component<LoginProps, LoginState> {

    constructor(props: LoginState) {
        super(props)

        this.state = {
        }

    }

    render() {
        return <div className="flex flex-row justify-center space-x-4 min-h-screen bg-gray-50 ">
            <section
                className="bg-gray-50 dark:bg-gray-900 min-h-screen justify-center flex flex-col md:block md:flex-row">
                <div className="mx-auto flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
                    <a
                        href="#"
                        className="mb-6 flex items-center text-2xl font-semibold text-gray-900 dark:text-white"
                    >
                        Erasmus Bot
                    </a>
                    <div
                        className="w-full rounded-lg bg-white shadow sm:max-w-md md:mt-0 xl:p-0 dark:border dark:border-gray-700 dark:bg-gray-800 min-w-96">
                        <div className="space-y-4 p-6 sm:p-8 md:space-y-6">
                            <h1 className="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                Sign in/up
                            </h1>
                            <form
                                className="space-y-4 md:space-y-6"
                                action={`api/login`}
                                method="POST"
                            >
                                <div>
                                    <label
                                        htmlFor="username"
                                        className="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        UserName
                                    </label>
                                    <input
                                        type="text"
                                        name="username"
                                        id="username"
                                        placeholder="user1"
                                        className="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <label
                                        htmlFor="password"
                                        className="mb-2 block text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        Password
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="••••••••"
                                        className="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 sm:text-sm dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg bg-blue-600 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-4"
                                >
                                    Sign in/up
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>;
    }
}

const container = document.getElementById("application");
const root = createRoot(container!);
root.render(<Login/>);