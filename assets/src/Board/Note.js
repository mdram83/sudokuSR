import React from "react";

export const Note = (props) => {
    return (
        <div className="flex justify-center h-1">
                <span className={
                    "inline-block align-middle leading-none"
                    + ((props.highlight && props.highlightNotes) ? " font-extrabold text-gray-900" : "")
                    + ((props.valueError && props.highlightErrors) ? " font-bold text-red-700" : " text-gray-500")
                }>
                    {props.value}
                </span>
        </div>
    );
}