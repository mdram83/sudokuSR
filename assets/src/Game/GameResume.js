import React from "react";
import {GameRepository} from "./GameRepository";
import {MessageButton} from "../Board/MessageButton";

export class GameResume extends React.Component
{
    constructor(props) {
        super(props);

        this.state = {
            isLoaded: false,
            isError: false,
            gameSet: null,
        };
    }

    handleCallback() {
        this.props.callback(this.state.gameSet, this.props.parent);
    }

    handleLoad = ({isLoaded, isError, gameSet = null} = {}) => {
        this.setState({
            isLoaded: isLoaded,
            isError: isError,
            gameSet: gameSet,
        });
    }

    componentDidMount() {
        GameRepository.load(null, true, this.handleLoad);
    }

    render() {

        if (!this.state.isLoaded || this.state.isError || this.state.gameSet === null) {
            return;
        } else {
            return <MessageButton message="CONTINUE..." action={() => this.handleCallback()}/>;
        }
    }
}