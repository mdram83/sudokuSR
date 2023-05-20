import React from "react";

export const Key = (props) => {
    return (
        <div
            className={
                "relative border rounded flex justify-center m-0 p-0 hover:cursor-default focus:outline-none"
                + (!props.highlightRemaining || props.anyRemaining
                        ? " hover:bg-gray-300 border-gray-400"
                        : " hover:bg-gray-100 border-gray-200 text-gray-400"
                )
            }
            key={props.digit}
            onClick={props.onClick}
        >
            <span className="inline-block align-middle m-0 p-0 pt-0.5">
                {props.digit}
            </span>
            {
                props.highlightRemaining && props.anyRemaining
                &&
                <span className="absolute top-0 right-0 px-0.5 text-[7pt] font-bold text-emerald-600">
                    {props.countRemaining}
                </span>
            }
        </div>
    );
}