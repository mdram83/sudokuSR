import React from 'react';
import {Board} from "./Board/Board";
import {difficultyLevel} from "./Game/difficultyLevel";

export class Sudoku extends React.Component
{
    constructor(props) {
        super(props);

        this.state = {
            isLoaded: false,
            error: false,
            sudoku: {},
        };
    }

    componentDidMount() {

        const xhr = new XMLHttpRequest();

        xhr.addEventListener("readystatechange", () => {
            if (xhr.readyState === 4) {

                if (xhr.status === 200) {

                    let json = JSON.parse(xhr.responseText);

                    this.setState({
                        isLoaded: true,
                        gameSet: {
                            initialBoard: json.board,
                        },
                    });

                } else {

                    this.setState({
                        isLoaded: true,
                        error: true
                    });
                }
            }
        });

        xhr.open("GET", "/ajax/game/random", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.send();

    }

    render() {

        if (!this.state.isLoaded) {
            return <div>Loading...</div>;
        } else if (this.state.error) {
            return <div>Error loading Sudoku</div>;
        } else {
            return <div><Board difficultyLevel={difficultyLevel} gameSet={this.state.gameSet} /></div>;
        }
    }
}
