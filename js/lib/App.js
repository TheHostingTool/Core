

/**
 * The `App` class provides a container for an application, as well as various
 * utilities for the rest of the app to use.
 */
export default class App {

    constructor() {

        /**
         * A map of routes, keyed by a unique route name. Each route is an object
         * containing the following properties:
         *
         * - `path` The path that the route is accessed at.
         * - `component` The Mithril component to render when this route is active.
         *
         * @example
         * app.routes.client.ticket = {path: '/clients/ticket/:id', component: TicketPage.component()};
         *
         * @type {Object}
         * @public
         */
        this.routes = {};

        /**
         * The app's session
         * @type {null}
         */
        this.session = null;

        /**
         * The app's data store
         * @type {null}
         */
        this.store = null;

        /**
         * A local cache that can be used to store data at the application level, so
         * that is persists between different routes.
         *
         * @type {Object}
         * @public
         */
        this.cache = {};

        /**
         * Whether or not the app has been booted.
         *
         * @type {Boolean}
         * @public
         */
        this.booted = false;

    }

    /**
     * Boot the application by running all of the registered initializers.
     *
     * @public
     */
    boot(data) {
        this.data = data;


    }

    /**
     * Construct a URL to the route with the given name.
     *
     * @param {String} name
     * @param {Object} params
     * @return {String}
     * @public
     */
    route(name, params = {}) {
        const url = this.routes[name]
    }
}
