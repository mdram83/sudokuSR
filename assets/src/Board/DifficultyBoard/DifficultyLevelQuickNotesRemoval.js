import React from "react";
import {styles} from "../../Styles/styles";

export const DifficultyLevelQuickNotesRemoval = (props) => {

    const numbers = [1, 2, 1, 1, 5, 6, 1, 8, 9]
    const elements = [];

    for (let i = 0; i < 9; i++) {
        elements.push(
            <div key={i} className={
                "flex justify-center h-1"
                + (numbers[i] === 1 ? " text-gray-700" : " text-gray-400")
                + (i === 0 ? " font-extrabold" : "")
                + (numbers[i] === 1 && i !== 0 ? " line-through" : "")
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