import Vue from 'vue'
import { library, config, dom } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import {
  faCog,
  faEdit,
  faEye,
  faListUl,
  faLock,
  faSignOutAlt,
  faSort,
  faSortAlphaDown,
  faSortAlphaUp,
  faTrashAlt,
  faUser,
  faUserCheck,
  faUserEdit,
  faUserPlus,
  faUsers,
  faUserTimes
} from '@fortawesome/free-solid-svg-icons'

library.add(
  faCog,
  faEdit,
  faEye,
  faListUl,
  faLock,
  faSignOutAlt,
  faSort,
  faSortAlphaDown,
  faSortAlphaUp,
  faTrashAlt,
  faUser,
  faUserCheck,
  faUserEdit,
  faUserPlus,
  faUsers,
  faUserTimes
)

/**
 * Setting this config so that Vue-tables-2 will be able to replace sort icons with chevrons
 * https://fontawesome.com/how-to-use/with-the-api/setup/configuration
 */
config.autoReplaceSvg = 'nest'

/**
 * Allows DOM to change <i> tags to SVG for more features like layering
 * https://fontawesome.com/how-to-use/on-the-web/styling/layering
 */
dom.watch()

Vue.component('fa', FontAwesomeIcon)
