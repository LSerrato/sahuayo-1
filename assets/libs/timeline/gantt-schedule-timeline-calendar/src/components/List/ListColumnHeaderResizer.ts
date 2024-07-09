/**
 * ListColumnHeaderResizer component
 *
 * @copyright Rafal Pospiech <https://neuronet.io>
 * @author    Rafal Pospiech <neuronet.io@gmail.com>
 * @package   gantt-schedule-timeline-calendar
 * @license   AGPL-3.0 (https://github.com/neuronetio/gantt-schedule-timeline-calendar/blob/master/LICENSE)
 * @link      https://github.com/neuronetio/gantt-schedule-timeline-calendar
 */

export default function ListColumnHeaderResizer(vido, props) {
  const { api, state, onDestroy, update, html, schedule, Actions, PointerAction, cache, StyleMap } = vido;

  const componentName = 'list-column-header-resizer';
  const componentActions = api.getActions(componentName);
  const componentDotsActions = api.getActions(componentName + '-dots');

  let wrapper;
  onDestroy(state.subscribe('config.wrappers.ListColumnHeaderResizer', value => (wrapper = value)));

  let column;
  onDestroy(
    state.subscribe(`config.list.columns.data.${props.columnId}`, val => {
      column = val;
      update();
    })
  );

  let className, containerClass, dotsClass, dotClass, calculatedWidth;
  const dotsStyleMap = new StyleMap({ width: '' });
  let inRealTime = false;
  onDestroy(
    state.subscribe('config.classNames', value => {
      className = api.getClass(componentName, { column });
      containerClass = api.getClass(componentName + '-container', { column });
      dotsClass = api.getClass(componentName + '-dots', { column });
      dotClass = api.getClass(componentName + '-dots-dot', { column });
      update();
    })
  );
  onDestroy(
    state.subscribeAll(
      [
        `config.list.columns.data.${column.id}.width`,
        'config.list.columns.percent',
        'config.list.columns.resizer.width',
        'config.list.columns.resizer.inRealTime'
      ],
      (value, path) => {
        const list = state.get('config.list');
        calculatedWidth = column.width * list.columns.percent * 0.01;
        dotsStyleMap.style['--width'] = list.columns.resizer.width + 'px';
        inRealTime = list.columns.resizer.inRealTime;
        state.update('_internal.list.width', calculatedWidth);
        update();
      }
    )
  );

  let dots = [1, 2, 3, 4, 5, 6, 7, 8];
  onDestroy(
    state.subscribe('config.list.columns.resizer.dots', value => {
      dots = [];
      for (let i = 0; i < value; i++) {
        dots.push(i);
      }
      update();
    })
  );

  /*
  let isMoving = false;
  const lineStyleMap = new StyleMap({
    '--display': 'none',
    '--left': left + 'px'
  });*/
  let left = calculatedWidth;
  const columnWidthPath = `config.list.columns.data.${column.id}.width`;

  const actionProps = {
    column,
    api,
    state,
    pointerOptions: {
      axis: 'x',
      onMove: function onMove({ movementX }) {
        let minWidth = state.get('config.list.columns.minWidth');
        if (typeof column.minWidth === 'number') {
          minWidth = column.minWidth;
        }
        left += movementX;
        if (left < minWidth) {
          left = minWidth;
        }
        if (inRealTime) {
          state.update(columnWidthPath, left);
        }
      }
    }
  };

  componentActions.push(PointerAction);
  const actions = Actions.create(componentActions, actionProps);
  const dotsActions = Actions.create(componentDotsActions, actionProps);

  return templateProps =>
    wrapper(
      html`
        <div class=${className} data-actions=${actions}>
          <div class=${containerClass}>
            ${cache(
              column.header.html
                ? html`
                    ${column.header.html}
                  `
                : column.header.content
            )}
          </div>
          <div class=${dotsClass} style=${dotsStyleMap} data-actions=${dotsActions}>
            ${dots.map(
              dot =>
                html`
                  <div class=${dotClass} />
                `
            )}
          </div>
        </div>
      `,
      { vido, props, templateProps }
    );
}
