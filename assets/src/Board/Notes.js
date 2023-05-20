import React from "react";
import {Note} from "./Note";

export const Notes = (props) => {

    const elements = [];

    for (let i = 0; i < 9; i++) {
        elements.push(
            <Note
                key={i}
                value={props.notes[i]}
                valueError={props.notesErrors[i]}
                highlight={props.highlightedDigit === props.notes[i]}
                highlightNotes={props.highlightNotes}
                highlightErrors={props.highlightErrors}
            />
        );
    }

    return (
        <div className="grid grid-cols-3 gap-0 text-[7pt] w-full h-full">
            {elements}
        </div>
    );
}