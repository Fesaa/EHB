// @ts-ignore
import React, {Component} from "react";
import {FullChatInfo} from "../payload/info";
import axios from "axios";
import {PaperAirplaneIcon} from "@heroicons/react/24/outline";

export type ChatBoxProps = {
    id: string
}

export type ChatBoxState = {
    full: FullChatInfo | null
    query: string
}

export class ChatBox extends Component<ChatBoxProps, ChatBoxState> {

    constructor(props: ChatBoxProps) {
        super(props);
        this.state = {
            full: null,
            query: ""
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
        console.log(this.state.query)
    }

    render() {
        if (this.state.full == null && this.props.id !== "") {
            return <div className="flex flex-grow">
                <h1>Loading...</h1>
            </div>
        }

        return <div className="flex flex-col flex-grow items-center px-40">
            <span className="text-2xl mt-10 fixed top-5">{this.state.full && this.state.full.name}</span>
            <div className="flex flex-grow flex-col mx-10 my-20 space-y-5 w-full overflow-auto">
                {this.state.full && this.state.full.chatHistory.map((msg, index) => {
                    return <div key={`message_${index}`} className={`flex flex-row ${msg.user ? "justify-end" : "justify-start"} mx-10 my-2`}>
                        <div className={`${msg.user ? "bg-red-200" : "bg-blue-200"} p-5 rounded-xl max-w-64`}>
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
                    onChange={(e) => {
                        this.setState({
                            ...this.state,
                            query: e.target.value
                        })
                    }}
                />
                <PaperAirplaneIcon className="w-8 h-8 hover:cursor-pointer" onClick={(e) => this.sendMessage()} />
            </div>
        </div>;
    }

}