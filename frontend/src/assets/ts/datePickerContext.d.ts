interface DatePickerContext {
    inputValue: string | { start: string; end: string };
    inputEvents: object;
    showPopover: (opts?: Partial<PopoverOptions>) => void;
    hidePopover: (opts?: Partial<PopoverOptions>) => void;
    togglePopover: (opts: Partial<PopoverOptions>) => void;
    // outras propriedades e métodos, se houver
  }