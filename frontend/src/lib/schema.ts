import { z } from 'zod';

export const ProfileTranslationSchema = z
  .object({
    city: z.string().nullable().optional(),
    headline: z.string().nullable().optional(),
    headlineHighlight: z.string().nullable().optional(),
    availabilityLabel: z.string().nullable().optional(),
    aboutPrimary: z.string().nullable().optional(),
    aboutSecondary: z.string().nullable().optional(),
  })
  .passthrough();

export const ExperienceTranslationSchema = z
  .object({
    role: z.string().nullable().optional(),
    company: z.string().nullable().optional(),
    impact: z.string().nullable().optional(),
  })
  .passthrough();

export const ProjectTranslationSchema = z
  .object({
    name: z.string().nullable().optional(),
    description: z.string().nullable().optional(),
    imageAlt: z.string().nullable().optional(),
  })
  .passthrough();

export const ProfileSchema = z.object({
  name: z.string().min(1),
  handle: z.string().min(1),
  city: z.string(),
  headline: z.string(),
  headlineHighlight: z.string(),
  isAvailable: z.boolean(),
  availabilityLabel: z.string(),
  about: z.object({
    primary: z.string(),
    secondary: z.string(),
  }),
  tools: z.array(z.string()),
  email: z.string(),
  resumeUrl: z.string().url().nullable(),
  translations: z
    .object({
      en: ProfileTranslationSchema.optional(),
      es: ProfileTranslationSchema.optional(),
    })
    .optional(),
});

export const SocialLinkSchema = z.object({
  label: z.string().min(1),
  url: z.string().url(),
  showInHero: z.boolean(),
  showInContact: z.boolean(),
});

export const ExperienceSchema = z.object({
  role: z.string(),
  company: z.string(),
  startYear: z.number().int().min(1900).max(2100),
  endYear: z.number().int().min(1900).max(2100).nullable(),
  impact: z.string(),
  translations: z
    .object({
      en: ExperienceTranslationSchema.optional(),
      es: ExperienceTranslationSchema.optional(),
    })
    .optional(),
});

export const ProjectImageSchema = z.object({
  url: z.string().url(),
  alt: z.string(),
  width: z.number().int().positive(),
  height: z.number().int().positive(),
});

export const ProjectSchema = z.object({
  number: z.string().regex(/^\d{2,}$/),
  name: z.string(),
  slug: z.string(),
  year: z.number().int().min(1900).max(2100),
  description: z.string(),
  tags: z.array(z.string()),
  liveUrl: z.string().url().nullable(),
  repoUrl: z.string().url().nullable(),
  image: ProjectImageSchema.nullable(),
  translations: z
    .object({
      en: ProjectTranslationSchema.optional(),
      es: ProjectTranslationSchema.optional(),
    })
    .optional(),
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
