const { __ } = wp.i18n;
const { compose } = wp.compose;
const { withSelect, withDispatch } = wp.data;

const { PluginDocumentSettingPanel } = wp.editPost;
const { ToggleControl, TextControl, PanelRow, ResponsiveWrapper } = wp.components;

import { Button } from '@wordpress/components';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';

const AWP_Custom_Plugin = ( { postType, postMeta, setPostMeta } ) => {
    // Will only render component for post type 'emt_products'
	if ( 'emt_products' !== postType ) return null;

	return(
		<PluginDocumentSettingPanel title={ __( 'Product Settings', 'emt_task_domain') } icon="edit" initialOpen="true">
            <PanelRow>
				<TextControl
					label={ __( 'Product price', 'emt_task_domain' ) }
					value={ postMeta._price }
					onChange={ ( value ) => setPostMeta( { _price: value } ) }
				/>
			</PanelRow>
            <br />
            <PanelRow>
				<ToggleControl
					label={ __( 'Is product on sale?', 'emt_task_domain' ) }
					onChange={ ( value ) => setPostMeta( { _is_on_sale: value } ) }
					checked={ postMeta._is_on_sale }
				/>
			</PanelRow>
            <PanelRow>
				<TextControl
					label={ __( 'Sale price', 'emt_task_domain' ) }
					value={ postMeta._sale_price }
					onChange={ ( value ) => setPostMeta( { _sale_price: value } ) }
				/>
			</PanelRow>
			<PanelRow>
				<TextControl
					label={ __( 'YouTube video link', 'emt_task_domain' ) }
					value={ postMeta._youtube_video }
					onChange={ ( value ) => setPostMeta( { _youtube_video: value } ) }
				/>
			</PanelRow>
            <PanelRow>
                <h4>
                    {__( 'Product Gallery', 'emt_task_domain' )}
                </h4>
            </PanelRow>
            <PanelRow>
                {(postMeta._gallery_urls.length > 0 &&
                postMeta._gallery_urls.split(',').map(url => (
                    <figure>
                        <img src={url} width="75px" height="75px"/>
                    </figure>
                )))
                }
            </PanelRow>
            <PanelRow>
                <MediaUploadCheck>
                    <MediaUpload
                        gallery = {true}
                        addToGallery = {true}
                        onSelect={
                            ( media ) => {
                                let ids = [];
                                media.forEach(element => {
                                    ids.push(element.id);
                                });
                                ids = ids.join();
                                setPostMeta( { _gallery: ids } );

                                let urls = [];
                                media.forEach(element => {
                                    urls.push(element.sizes.thumbnail.url);
                                });
                                urls = urls.join();
                                setPostMeta( { _gallery_urls: urls } );
                            }
                        }
                        value = {postMeta._gallery.split(',')}
                        multiple = {true}
                        render={ ( { open } ) => (
                            <Button className={'button media-button button-primary button-large media-button-insert'} onClick={ open }>Open Media Library</Button>
                        ) }
                    />
                </MediaUploadCheck>
            </PanelRow>
		</PluginDocumentSettingPanel>
	);
}

export default compose( [
	withSelect( ( select ) => {
		return {
			postMeta: select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
			postType: select( 'core/editor' ).getCurrentPostType(),
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			setPostMeta( newMeta ) {
				dispatch( 'core/editor' ).editPost( { meta: newMeta } );
			}
		};
	} )
] )( AWP_Custom_Plugin );
