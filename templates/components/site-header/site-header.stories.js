import twigTemplate from './template.twig';

export default {
	title: 'Components/Site Header',
	tags: ['autodocs'],
	argTypes: {
		site: {
			description:
				'The site object, with the mandatory `title` property.',
			type: 'object',
		},
		nav_items: {
			description:
				'The array consists of navigation items, where each item is required to contain both a title and a URL',
			type: 'array',
		},
	},
};

const Template = (args) => {
	const template = twigTemplate(args);
	return template;
};

export const Default = Template.bind({});
Default.args = {
	site: {
		title: 'TetraStarter WordPress Theme',
	},
	nav_items: [
		{
			title: 'Sample Page',
			url: '#',
		},
	],
};
