import React from "react";
import {styles} from "../../Styles/styles";

export const DifficultyLevelHighlightGrid = (props) => {

    const numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9]
    const elements = [];

    for (let i = 0; i < 9; i++) {
        elements.push(
            <div key={i} className={
                "flex justify-center h-1"
                + (numbers[i] <= 4 || numbers[i] === 7 ? " text-gray-700" : " text-gray-400")
            }>
                <span className="inline-block align-middle leading-none">{numbers[i]}</span>
            </div>
        );
    }

    const className =
        styles.difficultyLevel.div.base
        + (props.active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <div className="grid grid-cols-3 gap-0 text-[7pt] w-full h-full">
                {elements}
            </div>
        </div>
    );
}