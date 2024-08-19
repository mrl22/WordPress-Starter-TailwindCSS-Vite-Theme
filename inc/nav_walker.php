<?php
/**
 * Custom fork of WP native Walker functionality revised so we can output
 * classes for tailwind and alpinejs
 *
 */

// Check if Class Exists.
if ( class_exists( '\Walker_Nav_Menu' ) ) {
    if ( ! class_exists( 'Walker_Nav_Menu_Tailwind' ) ) {
        /**
         * Walker_Nav_Menu_Tailwind class.
         *
         * @extends Walker_Nav_Menu
         */
        class Walker_Nav_Menu_Tailwind extends \Walker_Nav_Menu {

            /**
             * Starts the list before the elements are added.
             *
             * @param string $output Used to append additional content (passed by reference).
             * @param int $depth Depth of menu item. Used for padding.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             *
             * @see Walker_Nav_Menu::start_lvl()
             *
             * @since WP 3.0.0
             *
             */
            public function start_lvl( &$output, $depth = 0, $args = array() ): void {
                if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                    $t = '';
                    $n = '';
                } else {
                    $t = "\t";
                    $n = "\n";
                }
                $indent  = str_repeat( $t, $depth );
                $classes = array( 'dropdown-menu mt-2 mb-8 rounded overflow-hidden shadow-lg bg-white md:absolute list-reset lg:min-w-64' );

                $class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                // Alpine.js directive to show the menu
                $output .= "{$n}{$indent}<ul$class_names x-show=\"open\" x-cloak x-transition:enter=\"transition ease-out duration-200\" x-transition:enter-start=\"opacity-0 transform scale-95\" x-transition:enter-end=\"opacity-100 transform scale-100\" x-transition:leave=\"transition ease-in duration-75\" x-transition:leave-start=\"opacity-100 transform scale-100\" x-transition:leave-end=\"opacity-0 transform scale-95\" role=\"menu\">{$n}";
            }

            /**
             * Starts the element output.
             *
             * @param string $output Used to append additional content (passed by reference).
             * @param WP_Post $item Menu item data object.
             * @param int $depth Depth of menu item. Used for padding.
             * @param stdClass $args An object of wp_nav_menu() arguments.
             * @param int $id Current item ID.
             *
             * @see Walker_Nav_Menu::start_el()
             *
             * @since WP 3.0.0
             * @since WP 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
             *
             */
            public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ): void {
                if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
                    $t = '';
                    $n = '';
                } else {
                    $t = "\t";
                    $n = "\n";
                }
                $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

                $classes = empty( $item->classes ) ? array() : (array) $item->classes;

                $linkmod_classes   = array();
                $icon_classes      = array();
                $classes           = self::separate_linkmods_and_icons_from_classes( $classes, $linkmod_classes, $icon_classes, $depth );
                $icon_class_string = join( ' ', $icon_classes );

                $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

                if ( isset( $args->has_children ) && $args->has_children ) {
                    $classes[] = 'dropdown lg:mx-2 relative lg:pb-0 lg:mb-0';
                }
//		        if ($depth === 0) {
//			        $classes[] = '';
//		        }

                if ( in_array( 'current-menu-item', $classes, true ) || in_array( 'current-menu-parent', $classes, true ) ) {
                    $classes[] = 'active';
                }

                $classes[] = 'menu-item-' . $item->ID;
                $classes[] = 'nav-item relative';

                $classes     = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth );
                $class_names = join( ' ', $classes );
                $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

                $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
                $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

                // Add Alpine.js attributes for dropdown functionality
                $alpine_data = ( isset( $args->has_children ) && $args->has_children ) ? ' x-data="{ open: false }" x-on:click.outside="open = false"' : '';
                $output      .= $indent . '<li' . $alpine_data . ' itemscope="itemscope" itemtype="https://www.schema.org/SiteNavigationElement"' . $id . $class_names . '>';

                $atts = array();

                if ( empty( $item->attr_title ) ) {
                    $atts['title'] = ! empty( $item->title ) ? strip_tags( $item->title ) : '';
                } else {
                    $atts['title'] = $item->attr_title;
                }

                $atts['target'] = ! empty( $item->target ) ? $item->target : '';
                $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';

                // Alpine.js toggle attribute
                $atts['@click'] = 'open = !open';

                if ( isset( $args->has_children ) && $args->has_children && 0 === $depth && $args->depth > 1 ) {
                    $atts['href']          = '#';
                    $atts['data-toggle']   = 'dropdown';
                    $atts['aria-haspopup'] = 'true';
                    $atts['aria-expanded'] = 'false';
                    $atts['class']         = 'dropdown-toggle nav-link';
                    $atts['id']            = 'menu-item-dropdown-' . $item->ID;
                } else {
                    $atts['href'] = ! empty( $item->url ) ? $item->url : '#';
                    if ( $depth > 0 ) {
                        $atts['class'] = 'dropdown-item text-black w-full block px-3 py-1.5 hover:bg-indigo-600 hover:text-white';
                    } else {
                        $atts['class'] = 'nav-link p-3';
                    }
                }

                $atts['aria-current'] = $item->current ? 'page' : '';

                $atts = self::update_atts_for_linkmod_type( $atts, $linkmod_classes );
                $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

                $attributes = '';
                foreach ( $atts as $attr => $value ) {
                    if ( ! empty( $value ) ) {
                        $value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }

                $linkmod_type = self::get_linkmod_type( $linkmod_classes );

                $item_output = $args->before ?? '';

                if ( '' !== $linkmod_type ) {
                    $item_output .= self::linkmod_element_open( $linkmod_type, $attributes );
                } else {
                    $item_output .= '<a' . $attributes . '>';
                }

                $icon_html = '';
                if ( ! empty( $icon_class_string ) ) {
                    $icon_html = '<i class="' . esc_attr( $icon_class_string ) . '" aria-hidden="true"></i> ';
                }

                $title = apply_filters( 'the_title', esc_html( $item->title ), $item->ID );
                $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

                if ( in_array( 'sr-only', $linkmod_classes, true ) ) {
                    $title         = self::wrap_for_screen_reader( $title );
                    $keys_to_unset = array_keys( $linkmod_classes, 'sr-only', true );
                    foreach ( $keys_to_unset as $k ) {
                        unset( $linkmod_classes[ $k ] );
                    }
                }

                $item_output .= isset( $args->link_before ) ? $args->link_before . $icon_html . $title . $args->link_after : '';

                if ( '' !== $linkmod_type ) {
                    $item_output .= self::linkmod_element_close( $linkmod_type );
                } else {
                    $item_output .= '</a>';
                }

                $item_output .= $args->after ?? '';

                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }


            /**
             * Traverse elements to create list from elements.
             *
             * Display one element if the element doesn't have any children otherwise,
             * display the element and its children. Will only traverse up to the max
             * depth and no ignore elements under that depth. It is possible to set the
             * max depth to include all depths, see walk() method.
             *
             * This method should not be called directly, use the walk() method instead.
             *
             * @param object $element Data object.
             * @param array $children_elements List of elements to continue traversing (passed by reference).
             * @param int $max_depth Max depth to traverse.
             * @param int $depth Depth of current element.
             * @param array $args An array of arguments.
             * @param string $output Used to append additional content (passed by reference).
             *
             * @since WP 2.5.0
             *
             * @see Walker::start_lvl()
             *
             */
            public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ): void {
                if ( ! $element ) {
                    return;
                }
                $id_field = $this->db_fields['id'];
                // Display this element.
                if ( is_object( $args[0] ) ) {
                    $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
                }
                parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
            }

            /**
             * Menu Fallback.
             *
             * If this function is assigned to the wp_nav_menu's fallback_cb variable
             * and a menu has not been assigned to the theme location in the WordPress
             * menu manager the function with display nothing to a non-logged in user,
             * and will add a link to the WordPress menu manager if logged in as an admin.
             *
             * @param array $args passed from the wp_nav_menu function.
             */
            public static function fallback( array $args ) {
                if ( current_user_can( 'edit_theme_options' ) ) {

                    // Get Arguments.
                    $container       = $args['container'];
                    $container_id    = $args['container_id'];
                    $container_class = $args['container_class'];
                    $menu_class      = $args['menu_class'];
                    $menu_id         = $args['menu_id'];

                    // Initialize var to store fallback html.
                    $fallback_output = '';

                    if ( $container ) {
                        $fallback_output .= '<' . esc_attr( $container );
                        if ( $container_id ) {
                            $fallback_output .= ' id="' . esc_attr( $container_id ) . '"';
                        }
                        if ( $container_class ) {
                            $fallback_output .= ' class="' . esc_attr( $container_class ) . '"';
                        }
                        $fallback_output .= '>';
                    }
                    $fallback_output .= '<ul';
                    if ( $menu_id ) {
                        $fallback_output .= ' id="' . esc_attr( $menu_id ) . '"';
                    }
                    if ( $menu_class ) {
                        $fallback_output .= ' class="' . esc_attr( $menu_class ) . '"';
                    }
                    $fallback_output .= '>';
                    $fallback_output .= '<li class="nav-item"><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" class="nav-link" title="' . esc_attr__( 'Add a menu', 'wp-tailwind-navwalker' ) . '">' . esc_html__( 'Add a menu', 'wp-tailwind-navwalker' ) . '</a></li>';
                    $fallback_output .= '</ul>';
                    if ( $container ) {
                        $fallback_output .= '</' . esc_attr( $container ) . '>';
                    }

                    // If $args has 'echo' key and it's true echo, otherwise return.
                    if ( array_key_exists( 'echo', $args ) && $args['echo'] ) {
                        echo $fallback_output; // WPCS: XSS OK.
                    } else {
                        return $fallback_output;
                    }
                }

            }

            /**
             * Find any custom linkmod or icon classes and store in their holder
             * arrays then remove them from the main classes array.
             *
             * Supported linkmods: .disabled, .dropdown-header, .dropdown-divider, .sr-only
             * Supported iconsets: Font Awesome 4/5, Glypicons
             *
             * NOTE: This accepts the linkmod and icon arrays by reference.
             *
             * @param array $classes an array of classes currently assigned to the item.
             * @param array $linkmod_classes an array to hold linkmod classes.
             * @param array $icon_classes an array to hold icon classes.
             * @param integer $depth an integer holding current depth level.
             *
             * @return array  $classes         a maybe modified array of classnames.
             * @since 4.0.0
             *
             */
            private function separate_linkmods_and_icons_from_classes( $classes, &$linkmod_classes, &$icon_classes, $depth ): array {
                // Loop through $classes array to find linkmod or icon classes.
                foreach ( $classes as $key => $class ) {
                    /*
                    * If any special classes are found, store the class in it's
                    * holder array and and unset the item from $classes.
                    */
                    if ( preg_match( '/^disabled|^sr-only/i', $class ) ) {
                        // Test for .disabled or .sr-only classes.
                        $linkmod_classes[] = $class;
                        unset( $classes[ $key ] );
                    } elseif ( preg_match( '/^dropdown-header|^dropdown-divider|^dropdown-item-text/i', $class ) && $depth > 0 ) {
                        /*
                        * Test for .dropdown-header or .dropdown-divider and a
                        * depth greater than 0 - IE inside a dropdown.
                        */
                        $linkmod_classes[] = $class;
                        unset( $classes[ $key ] );
                    } elseif ( preg_match( '/^fa-(\S*)?|^fa(s|r|l|b)?(\s?)?$/i', $class ) ) {
                        // Font Awesome.
                        $icon_classes[] = $class;
                        unset( $classes[ $key ] );
                    } elseif ( preg_match( '/^glyphicon-(\S*)?|^glyphicon(\s?)$/i', $class ) ) {
                        // Glyphicons.
                        $icon_classes[] = $class;
                        unset( $classes[ $key ] );
                    }
                }

                return $classes;
            }

            /**
             * Return a string containing a linkmod type and update $atts array
             * accordingly depending on the decided.
             *
             * @param array $linkmod_classes array of any link modifier classes.
             *
             * @return string                empty for default, a linkmod type string otherwise.
             * @since 4.0.0
             *
             */
            private function get_linkmod_type( array $linkmod_classes = [] ): string {
                $linkmod_type = '';
                // Loop through array of linkmod classes to handle their $atts.
                if ( ! empty( $linkmod_classes ) ) {
                    foreach ( $linkmod_classes as $link_class ) {
                        if ( ! empty( $link_class ) ) {

                            // Check for special class types and set a flag for them.
                            if ( 'dropdown-header' === $link_class ) {
                                $linkmod_type = 'dropdown-header';
                            } elseif ( 'dropdown-divider' === $link_class ) {
                                $linkmod_type = 'dropdown-divider';
                            } elseif ( 'dropdown-item-text' === $link_class ) {
                                $linkmod_type = 'dropdown-item-text';
                            }
                        }
                    }
                }

                return $linkmod_type;
            }

            /**
             * Update the attributes of a nav item depending on the limkmod classes.
             *
             * @param array $atts array of atts for the current link in nav item.
             * @param array $linkmod_classes an array of classes that modify link or nav item behaviors or displays.
             *
             * @return array                 maybe updated array of attributes for item.
             * @since 4.0.0
             *
             */
            private function update_atts_for_linkmod_type( array $atts = [], array $linkmod_classes = [] ): array {
                if ( ! empty( $linkmod_classes ) ) {
                    foreach ( $linkmod_classes as $link_class ) {
                        if ( ! empty( $link_class ) ) {
                            /*
                            * Update $atts with a space and the extra classname
                            * so long as it's not a sr-only class.
                            */
                            if ( 'sr-only' !== $link_class ) {
                                $atts['class'] .= ' ' . esc_attr( $link_class );
                            }
                            // Check for special class types we need additional handling for.
                            if ( 'disabled' === $link_class ) {
                                // Convert link to '#' and unset open targets.
                                $atts['href'] = '#';
                                unset( $atts['target'] );
                            } elseif ( 'dropdown-header' === $link_class || 'dropdown-divider' === $link_class || 'dropdown-item-text' === $link_class ) {
                                // Store a type flag and unset href and target.
                                unset( $atts['href'] );
                                unset( $atts['target'] );
                            }
                        }
                    }
                }

                return $atts;
            }

            /**
             * Wraps the passed text in a screen reader only class.
             *
             * @param string $text the string of text to be wrapped in a screen reader class.
             *
             * @return string      the string wrapped in a span with the class.
             * @since 4.0.0
             *
             */
            private function wrap_for_screen_reader( string $text = '' ): string {
                if ( $text ) {
                    $text = '<span class="sr-only">' . $text . '</span>';
                }

                return $text;
            }

            /**
             * Returns the correct opening element and attributes for a linkmod.
             *
             * @param string $linkmod_type a sting containing a linkmod type flag.
             * @param string $attributes a string of attributes to add to the element.
             *
             * @return string              a string with the openign tag for the element with attribibutes added.
             * @since 4.0.0
             *
             */
            private function linkmod_element_open( string $linkmod_type, string $attributes = '' ): string {
                $output = '';
                if ( 'dropdown-item-text' === $linkmod_type ) {
                    $output .= '<span class="dropdown-item-text"' . $attributes . '>';
                } elseif ( 'dropdown-header' === $linkmod_type ) {
                    /*
                    * For a header use a span with the .h6 class instead of a real
                    * header tag so that it doesn't confuse screen readers.
                    */
                    $output .= '<span class="dropdown-header h6"' . $attributes . '>';
                } elseif ( 'dropdown-divider' === $linkmod_type ) {
                    // This is a divider.
                    $output .= '<div class="dropdown-divider"' . $attributes . '>';
                }

                return $output;
            }

            /**
             * Return the correct closing tag for the linkmod element.
             *
             * @param string $linkmod_type a string containing a special linkmod type.
             *
             * @return string              a string with the closing tag for this linkmod type.
             * @since 4.0.0
             *
             */
            private function linkmod_element_close( string $linkmod_type ): string {
                $output = '';
                if ( 'dropdown-header' === $linkmod_type || 'dropdown-item-text' === $linkmod_type ) {
                    /*
                    * For a header use a span with the .h6 class instead of a real
                    * header tag so that it doesn't confuse screen readers.
                    */
                    $output .= '</span>';
                } elseif ( 'dropdown-divider' === $linkmod_type ) {
                    // This is a divider.
                    $output .= '</div>';
                }

                return $output;
            }
        }
    }
}