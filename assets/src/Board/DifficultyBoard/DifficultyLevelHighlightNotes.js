import React from "react";
import {styles} from "../../Styles/styles";

export const DifficultyLevelHighlightNotes = (props) => {

    const numbers = [1, 2, null, 4, null, null, null, 8, null];
    const elements = [];
    for (let i = 0; i < 9; i++) {
        elements.push(
            <div key={i} className={"flex justify-center h-1"}>
                <span className={
                    "inline-block align-middle leading-none"
                    + (numbers[i] === 8 ? " text-gray-900 font-extrabold" : " text-gray-500")
                }>{numbers[i]}</span>
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