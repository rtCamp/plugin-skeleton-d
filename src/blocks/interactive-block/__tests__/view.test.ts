describe( 'Interactive Block view', () => {
	it( 'registers store with plugin-skeleton-d namespace', () => {
		const mockState = {
			isDark: false,
			darkText: 'Dark',
			lightText: 'Light',
		};
		const mockStore = jest.fn( () => ( { state: mockState } ) );
		const mockGetContext = jest.fn();

		jest.doMock( '@wordpress/interactivity', () => ( {
			store: mockStore,
			getContext: mockGetContext,
		} ) );

		jest.resetModules();
		require( '../view' );

		expect( mockStore ).toHaveBeenCalledWith(
			'plugin-skeleton-d',
			expect.any( Object )
		);
	} );

	it( 'store config contains expected structure', () => {
		const mockState = {
			isDark: false,
			darkText: 'Dark',
			lightText: 'Light',
		};
		const mockStore = jest.fn( () => ( { state: mockState } ) );
		const mockGetContext = jest.fn();

		jest.doMock( '@wordpress/interactivity', () => ( {
			store: mockStore,
			getContext: mockGetContext,
		} ) );

		jest.resetModules();
		require( '../view' );

		const calls = mockStore.mock.calls as unknown[][];
		expect( calls.length ).toBeGreaterThan( 0 );

		// eslint-disable-next-line @typescript-eslint/no-non-null-assertion
		const storeConfig = calls[ 0 ]![ 1 ]! as {
			state: Record< string, unknown >;
			actions: Record< string, () => void >;
			callbacks: Record< string, () => void >;
		};

		expect( storeConfig ).toHaveProperty( 'state' );
		expect( storeConfig ).toHaveProperty( 'actions' );
		expect( storeConfig ).toHaveProperty( 'callbacks' );
		expect( storeConfig.state ).toHaveProperty( 'themeText' );
		expect( storeConfig.actions ).toHaveProperty( 'toggleOpen' );
		expect( storeConfig.actions ).toHaveProperty( 'toggleTheme' );
		expect( storeConfig.callbacks ).toHaveProperty( 'logIsOpen' );
	} );
} );
