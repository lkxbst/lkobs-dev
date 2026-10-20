import { z } from 'zod';

export const ProfileSchema = z.object({
  name: z.string().min(1),
  handle: z.string().min(1),
  city: z.string().min(1),
  headline: z.string().min(1),
  headlineHighlight: z.string().min(1),
  isAvailable: z.boolean(),
  availabilityLabel: z.string().min(1),
  about: z.object({
    primary: z.string().min(1),
    secondary: z.string().min(1),
  }),
  tools: z.array(z.string().min(1)),
  email: z.string().min(1),
  resumeUrl: z.string().url().nullable(),
});

export const SocialLinkSchema = z.object({
  label: z.string().min(1),
  url: z.string().url(),
  showInHero: z.boolean(),
  showInContact: z.boolean(),
});

export const ExperienceSchema = z.object({
  role: z.string().min(1),
  company: z.string().min(1),
  startYear: z.number().int().min(1900).max(2100),
  endYear: z.number().int().min(1900).max(2100).nullable(),
  impact: z.string().min(1),
});

export const ProjectImageSchema = z.object({
  url: z.string().url(),
  alt: z.string().min(1),
  width: z.number().int().positive(),
  height: z.number().int().positive(),
});

export const ProjectSchema = z.object({
  number: z.string().regex(/^\d{2,}$/),
  name: z.string().min(1),
  slug: z.string().min(1),
  year: z.number().int().min(1900).max(2100),
  description: z.string().min(1),
  tags: z.array(z.string().min(1)),
  liveUrl: z.string().url().nullable(),
  repoUrl: z.string().url().nullable(),
  image: ProjectImageSchema.nullable(),
});

export const PortfolioPayloadSchema = z.object({
  profile: ProfileSchema,
  socialLinks: z.array(SocialLinkSchema),
  experiences: z.array(ExperienceSchema),
  projects: z.array(ProjectSchema),
  updatedAt: z.string().min(1),
});

export type Profile = z.infer<typeof ProfileSchema>;
export type SocialLink = z.infer<typeof SocialLinkSchema>;
export type Experience = z.infer<typeof ExperienceSchema>;
export type ProjectImage = z.infer<typeof ProjectImageSchema>;
export type Project = z.infer<typeof ProjectSchema>;
export type PortfolioPayload = z.infer<typeof PortfolioPayloadSchema>;
