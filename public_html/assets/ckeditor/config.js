/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

        // ALLOW <i></i>
        config.protectedSource.push( /<i[\s\S]*?\>/g ); //allows beginning <i> tag
        config.protectedSource.push( /<\/i[\s\S]*?\>/g ); //allows ending </i> tag

};
