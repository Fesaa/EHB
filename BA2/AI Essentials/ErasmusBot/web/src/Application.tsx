import {createRoot} from "react-dom/client";
// @ts-ignore
import React, {Component} from "react";
import {Sidebar} from "./components/Sidebar";
import {ChatBox} from "./components/ChatBox";
import {ChatInfo} from "./payload/info";
import axios from "axios";

type ApplicationProps = {

}

type ApplicationState = {
    chatData: ChatInfo[];
    currentChat: string;
}

class Application extends Component<ApplicationProps, ApplicationState> {

    constructor(props: ApplicationProps) {
        super(props);

        this.state = {
            chatData: [],
            currentChat: "",
        }

        this.setCurrentChat = this.setCurrentChat.bind(this);
        this.updateChatName = this.updateChatName.bind(this);
    }

    componentDidMount() {
        // @ts-ignore
        axios.get(`${BASE_URL}/api/chats/`)
            .then((res) => {
                if (!res || !res.data) return
                this.setState({
                    ...this.state,
                    chatData: res.data
                })
            })
            .catch((err) => {
                console.error(err);
            })
    }

    private updateChatName(id: string, name: string) {
        const chatData = this.state.chatData.map((ci) => {
            if (ci.id === id) {
                return {
                    ...ci,
                    name: name
                }
            }
            return ci;
        })

        this.setState({
            ...this.state,
            chatData: chatData
        })
    }

    private setCurrentChat(id: string, ci?: ChatInfo) {
        if (ci) {
            this.setState({
                ...this.state,
                currentChat: id,
                chatData: [...this.state.chatData, ci]
            })
            return;
        }


        this.setState({
            ...this.state,
            currentChat: id
        })
    }

    render() {
        return <div className="flex flex-row space-x-4 min-h-screen">
            <Sidebar data={this.state.chatData} setCurrentChat={this.setCurrentChat} />
            <ChatBox id={this.state.currentChat} updateChatName={this.updateChatName} />
        </div>;
    }
}

const container = document.getElementById("application");
const root = createRoot(container!);
root.render(<Application />);