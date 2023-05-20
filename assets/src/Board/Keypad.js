import React from "react";
import {Key} from "./Key";

export class Keypad extends React.Component {

    handleKeyClick(digit) {
        this.props.setCellContent(digit)
    }

    render() {
        const elements = [];

        for (let digit = 1; digit <= 9; digit++) {

            elements.push(
                <Key
                    key={digit}
                    digit={digit}
                    onClick={() => this.handleKeyClick(digit)}
                    anyRemaining={this.props.valuesCount.get(digit) < 9}
                    countRemaining={Math.max(9 - this.props.valuesCount.get(digit), 0)}
                    highlightRemaining={this.props.difficultyLevel.highlightRemaining}
                />
            );
        }

        return (
            <div className="grid grid-cols-9 gap-1 w-72 h-8 mt-8">
                {elements}
            </div>
        );
    }
}