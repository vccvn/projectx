export type InpEvent = {
    name: string,
    value: any,
    old?: any,
    [prop: string]: any
}



export type DynamicEvent = {
    type: string,
    data?: any,
    [extra: string]: any
}

export type CallbackFunction = (...args: any[]) => any;

export const FG_POSKEYS = {
    x: ["left", "center", "right"],
    y: ["top", "center", "bottom"],
    xy: [
        "left-top", "center-top", "right-top",
        "left-center", "center-center", "right-center",
        "left-bottom", "center-bottom", "right-bottom"
    ]
};
export const FG_REPEAT = {
    repeat: "Auto",
    no: "no-repeat",
    x: "repeat-x",
    y: "repeat-y"
};

export const FG_BGSIZES = {
    auto: "Auto",
    contain: "Contain",
    cover: "Cover"
}


export interface FG_ITEM {
    secret_key?: string
    name?: string
    url?: string
    position?: { x: string, y: string }
    size?: string
    opacity?: number
    repeat?: string
}
export const FG_DEFAULT_DATA: FG_ITEM = {
    name: "foreground",
    url: "",
    position: {
        x: "center",
        y: "center"
    },
    repeat: "no",
    opacity: 1,
    size: "contain",
};
