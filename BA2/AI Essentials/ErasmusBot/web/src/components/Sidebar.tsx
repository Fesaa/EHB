// @ts-ignore
import React, {Component} from "react";
import {ChatInfo} from "../payload/info";
import {ChatBubbleBottomCenterTextIcon} from "@heroicons/react/24/outline";
import axios from "axios";

export type SidebarProps = {
    data: ChatInfo[]
    setCurrentChat: (id: string, ci?: ChatInfo) => void
}

export type SidebarState = {
    currentChat: string;
    show: boolean
}

export class Sidebar extends Component<SidebarProps, SidebarState> {
    constructor(props: SidebarProps) {
        super(props);
        this.state = {
            currentChat: "",
            show: true
        }
    }

    newChat() {
        // @ts-ignore
        axios.post(`${BASE_URL}/api/chats/new`)
            .then(res => {
                if (!res || !res.data) return;
                const ci: ChatInfo = res.data;
                this.setState({
                    ...this.state,
                    currentChat: ci.id
                })
                this.props.setCurrentChat(ci.id, ci);
            }).catch(err => {
                console.error(err);
            })
    }

    render() {
        if (!this.state.show) {
            return <div className="bg-white flex p-5">
                <ChatBubbleBottomCenterTextIcon onClick={() => {
                    this.setState({
                        ...this.state,
                        show: true
                    })
                }} className="h-5 w-5"/>
            </div>
        }


        return <div className="flex flex-col items-start flex-none w-36 p-5 bg-amber-50 space-y-5">
            <div onClick={() => {
                this.setState({
                    ...this.state,
                    show: false
                })
            }}>
                <ChatBubbleBottomCenterTextIcon className="h-5 w-5 hover:cursor-pointer"/>
            </div>


            <div className="rounded-xl bg-gray-200 p-2 hover:cursor-pointer text-center">
                <span onClick={() => this.newChat()}>New chat</span>
            </div>
            {this.props.data.length > 0 && <span className="font-bold">Past chats</span>}
            {this.props.data.length > 0 && this.props.data.map((chat) => {
                const bg = this.state.currentChat === chat.id ? "bg-gray-200" : "";
                return <div
                    key={chat.id}
                    className={`p-2 rounded-xl ${bg} hover:cursor-pointer`}
                    onClick={() => {
                        this.setState({
                            ...this.state,
                            currentChat: chat.id
                        })
                        this.props.setCurrentChat(chat.id);
                    }}
                >
                    <h1>{chat.name}</h1>
                </div>
            })}
            <div className="flex justify-self-end">
                <button
                    className="bg-gray-200 p-2 rounded-xl hover:cursor-pointer"
                    onClick={() => {
                        // @ts-ignore
                        axios.post(`${BASE_URL}/api/logout`)
                            .then((res) => {
                                window.location.href = "/login";
                            })
                            .catch((err) => {
                                console.error(err);
                            })
                    }}
                >
                    Logout
                </button>
            </div>
        </div>;
    }
}