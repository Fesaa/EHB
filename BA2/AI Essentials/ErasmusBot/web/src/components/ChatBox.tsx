// @ts-ignore
import React, {Component} from "react";
import {ChatMessage, FullChatInfo} from "../payload/info";
import axios from "axios";
import {PaperAirplaneIcon, PencilIcon} from "@heroicons/react/24/outline";

export type ChatBoxProps = {
    id: string
    updateChatName: (id: string, name: string) => void
}

export type ChatBoxState = {
    full: FullChatInfo | null
    query: string
    renaming: boolean
    newTitle: string
    coolDown: boolean
}

export class ChatBox extends Component<ChatBoxProps, ChatBoxState> {

    constructor(props: ChatBoxProps) {
        super(props);
        this.state = {
            full: null,
            query: "",
            renaming: false,
            newTitle: "",
            coolDown: false
        }
    }

    componentDidMount() {
        const element = document.getElementById('last');
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }

    shouldComponentUpdate(nextProps:Readonly<ChatBoxProps>, nextState:Readonly<ChatBoxState>, nextContext:any): boolean {
        if (this.props.id === nextProps.id) {
            return true;
        }

        // @ts-ignore
        axios.get(`${BASE_URL}/api/chats/full/${nextProps.id}`)
            .then((res) => {
                if (!res || !res.data) return
                this.setState({
                    ...this.state,
                    full: res.data
                })
            })
            .catch((err) => {
                console.error(err);
            })
        return true;
    }

    sendMessage() {
        if (this.state.coolDown) {
            return
        }

        const data = {
            query: this.state.query
        }
        this.state = {
            ...this.state,
            coolDown: true
        }
        // @ts-ignore
        axios.post(`${BASE_URL}/api/chats/${this.props.id}/msg`, data)
            .then((res) => {
                if (!res || !res.data) return

                const reply: ChatMessage = res.data;
                this.setState({
                    ...this.state,
                    query: "",
                    full: {
                        ...this.state.full,
                        chatHistory: [...this.state.full.chatHistory, {
                            user: true,
                            text: this.state.query
                        } , reply]
                    }
                })
                setTimeout(() => {
                    this.state = {
                        ...this.state,
                        coolDown: false
                    }
                }, 1000)
            }).catch((err) => {
                console.error(err);
            })
    }

    updateName() {
        const data = {
            name: this.state.newTitle
        }
        // @ts-ignore
        axios.post(`${BASE_URL}/api/chats/${this.props.id}/rename`, data)
            .then((res) => {
                if (!res || !res.data) return
                this.setState({
                    ...this.state,
                    renaming: false,
                    full: {
                        ...this.state.full,
                        name: this.state.newTitle
                    },
                    newTitle: ""
                })
                this.props.updateChatName(this.props.id, this.state.newTitle);
            }).catch((err) => {
                console.error(err);
            })
    }

    render() {
        if (this.state.full == null && this.props.id !== "") {
            return <div className="flex flex-grow">
                <h1>Loading...</h1>
            </div>
        }

        return <div className="flex flex-col flex-grow items-center px-40">
            {(!this.state.renaming && this.state.full) &&
                <div
                    className="text-2xl mt-10 fixed top-5"
                    onClick={() => {
                        this.setState({
                            ...this.state,
                            renaming: true
                        })
                    }}
                >
                    {this.state.full.name}
                </div>}
            {(this.state.renaming && this.state.full) && <div className="mt-10 fixed top-5 flex flex-row space-x-3">
                <input
                    className=""
                    type="text"
                    value={this.state.newTitle || this.state.full.name}
                    onChange={(e) => {
                        this.setState({
                            ...this.state,
                            newTitle: e.target.value
                        })
                    }}
                />
                <PencilIcon className="w-8 h-8" onClick={() => this.updateName()} />
            </div>}
            <div className="flex flex-grow flex-col mx-10 my-20 space-y-5 w-full overflow-auto mb-20">
                {this.state.full && this.state.full.chatHistory.map((msg, index) => {
                    return <div key={`message_${index}`} className={`flex flex-row ${msg.user ? "justify-end" : "justify-start"} mx-10 my-2`}>
                        <div
                            id={index == this.state.full.chatHistory.length - 1 ? "last": ""}
                            className={`${msg.user ? "bg-red-200" : "bg-blue-200"} p-5 rounded-xl max-w-3xl whitespace-pre-line`}>
                            {msg.text}
                        </div>
                    </div>
                })}
            </div>
            <div className="mb-10 fixed -bottom-5 flex flex-row space-x-5 justify-center items-center">
                <input
                    type="text"
                    className="rounded-xl p-5 bg-amber-50 min-w-96"
                    placeholder="Message ErasmusBot"
                    value={this.state.query}
                    onChange={(e) => {
                        this.setState({
                            ...this.state,
                            query: e.target.value
                        })
                    }}
                />
                <PaperAirplaneIcon className={`w-8 h-8 ${this.state.coolDown ? "hover:cursor-not-allowed" : "hover:cursor-pointer"}`} onClick={(e) => this.sendMessage()} />
            </div>
        </div>;
    }

}