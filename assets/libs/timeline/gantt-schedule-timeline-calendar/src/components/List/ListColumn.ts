/**
 * ListColumn component
 *
 * @copyright Rafal Pospiech <https://neuronet.io>
 * @author    Rafal Pospiech <neuronet.io@gmail.com>
 * @package   gantt-schedule-timeline-calendar
 * @license   AGPL-3.0 (https://github.com/neuronetio/gantt-schedule-timeline-calendar/blob/master/LICENSE)
 * @link      https://github.com/neuronetio/gantt-schedule-timeline-calendar
 */

/**
 * Bind element action
 */
class BindElementAction {
  constructor(element, data) {
    let shouldUpdate = false;
    let elements = data.state.get('_internal.elements.list-columns');
    if (typeof elements === 'undefined') {
      elements = [];
      shouldUpdate = true;
    }
    if (!elements.includes(element)) {
      elements.push(element);
      shouldUpdate = true;
    }
    if (shouldUpdate) data.state.update('_internal.elements.list-columns', elements);
  }
  public destroy(element, data) {
    data.state.update('_internal.elements.list-columns', elements => {
      return elements.filter(el => el !== element);
    });
  }
}

export default function ListColumn(vido, props) {
  const { api, state, onDestroy, onChange, Actions, update, createComponent, reuseComponents, html, StyleMap } = vido;

  let wrapper;
  onDestroy(state.subscribe('config.wrappers.ListColumn', value => (wrapper = value)));

  const componentsSub = [];
  let ListColumnRowComponent;
  componentsSub.push(state.subscribe('config.components.ListColumnRow', value => (ListColumnRowComponent = value)));
  let ListColumnHeaderComponent;
  componentsSub.push(
    state.subscribe('config.components.ListColumnHeader', value => (ListColumnHeaderComponent = value))
  );

  const actionProps = { ...props, api, state };

  const componentName = 'list-column';
  const rowsComponentName = componentName + '-rows';
  const componentActions = api.getActions(componentName);
  const rowsActions = api.getActions(rowsComponentName);
  let className, classNameContainer, calculatedWidth;

  const widthStyleMap = new StyleMap({ width: '', '--width': '' });
  const containerStyleMap = new StyleMap({ width: '', height: '' });
  const scrollCompensationStyleMap = new StyleMap({ width: '', height: '' });

  let column,
    columnPath = `config.list.columns.data.${props.columnId}`;

  let columnSub = state.subscribe(columnPath, function columnChanged(val) {
    column = val;
    update();
  });

  let width;
  function calculateStyle() {
    const list = state.get('config.list');
    const compensationY = state.get('config.scroll.compensation.y');
    calculatedWidth = list.columns.data[column.id].width * list.columns.percent * 0.01;
    width = calculatedWidth;
    const height = state.get('_internal.height');
    widthStyleMap.style.width = width + 'px';
    widthStyleMap.style['--width'] = width + 'px';
    containerStyleMap.style.height = height + 'px';
    scrollCompensationStyleMap.style.height = height + Math.abs(compensationY) + 'px';
    scrollCompensationStyleMap.style.transform = `translate(0px, ${compensationY}px)`;
  }
  let styleSub = state.subscribeAll(
    [
      'config.list.columns.percent',
      'config.list.columns.resizer.width',
      `config.list.columns.data.${column.id}.width`,
      '_internal.chart.dimensions.width',
      '_internal.height',
      'config.scroll.compensation.y',
      '_internal.list.width'
    ],
    calculateStyle,
    { bulk: true }
  );

  const ListColumnHeader = createComponent(ListColumnHeaderComponent, { columnId: props.columnId });
  onDestroy(ListColumnHeader.destroy);

  onChange(changedProps => {
    props = changedProps;
    for (const prop in props) {
      actionProps[prop] = props[prop];
    }
    if (columnSub) columnSub();
    ListColumnHeader.change({ columnId: props.columnId });
    columnPath = `config.list.columns.data.${props.columnId}`;
    columnSub = state.subscribe(columnPath, function columnChanged(val) {
      column = val;
      update();
    });

    if (styleSub) styleSub();
    styleSub = state.subscribeAll(
      [
        'config.list.columns.percent',
        'config.list.columns.resizer.width',
        `config.list.columns.data.${column.id}.width`,
        '_internal.chart.dimensions.width',
        '_internal.height',
        'config.scroll.compensation.y',
        '_internal.list.width'
      ],
      calculateStyle,
      { bulk: true }
    );

    ListColumnHeader.change(props);
  });

  onDestroy(() => {
    columnSub();
    styleSub();
  });

  onDestroy(
    state.subscribe('config.classNames', value => {
      className = api.getClass(componentName);
      classNameContainer = api.getClass(rowsComponentName);
      update();
    })
  );

  const visibleRows = [];
  const visibleRowsChange = val => {
    const destroy = reuseComponents(
      visibleRows,
      val || [],
      row => row && { columnId: props.columnId, rowId: row.id, width },
      ListColumnRowComponent
    );
    update();
    return destroy;
  };
  onDestroy(state.subscribe('_internal.list.visibleRows;', visibleRowsChange));

  onDestroy(() => {
    visibleRows.forEach(row => row.destroy());
    componentsSub.forEach(unsub => unsub());
  });

  function getRowHtml(row) {
    return row.html();
  }

  componentActions.push(BindElementAction);
  const headerActions = Actions.create(componentActions, { column, state: state, api: api });
  const rowActions = Actions.create(rowsActions, { api, state });

  return templateProps =>
    wrapper(
      html`
        <div class=${className} data-actions=${headerActions} style=${widthStyleMap}>
          ${ListColumnHeader.html()}
          <div class=${classNameContainer} style=${containerStyleMap} data-actions=${rowActions}>
            <div class=${classNameContainer + '--scroll-compensation'} style=${scrollCompensationStyleMap}>
              ${visibleRows.map(getRowHtml)}
            </div>
          </div>
        </div>
      `,
      { vido, props, templateProps }
    );
}
