export default function paginationFromHydraView(view) {
    if (view == undefined)
    {
        return undefined;
    }
    const first = view['hydra:first'];
    const previous = view['hydra:previous'];
    const next = view['hydra:next'];
    const last = view['hydra:last'];
    const current = view['@id'];
    return {
        first: first ? parseInt(new URLSearchParams(first.split('?')[1]).get('page'), 10) : undefined,
        previous: previous ? parseInt(new URLSearchParams(previous.split('?')[1]).get('page'), 10) : undefined,
        next: next ? parseInt(new URLSearchParams(next.split('?')[1]).get('page'), 10) : undefined,
        last: last ? parseInt(new URLSearchParams(last.split('?')[1]).get('page'), 10) : undefined,
        current: current ? parseInt(new URLSearchParams(current.split('?')[1]).get('page'), 10) : undefined,
    };
}
