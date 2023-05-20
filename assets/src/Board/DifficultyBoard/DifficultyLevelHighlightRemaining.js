import React from "react";
import {styles} from "../../Styles/styles";

export const DifficultyLevelHighlightRemaining = (props) => {

    const className =
        styles.difficultyLevel.div.base
        + (props.active ? styles.difficultyLevel.div.active : styles.difficultyLevel.div.default);

    return (
        <div className={className} onClick={props.onClick}>
            <span className="inline-block align-middle m-0 p-0 pt-0.5">9</span>
            <span className="absolute top-0 right-0 px-0.5 text-[7pt] font-bold text-emerald-600">3</span>
        </div>
    );
}