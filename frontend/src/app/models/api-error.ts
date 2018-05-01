export class ApiError {
    // A unique identifier for this particular occurrence of the problem
    protected id: string;

    // The HTTP status code applicable to this problem
    protected status: string;

    // An application-specific error code
    protected code: string;

    // A short, human-readable summary of the problem.
    protected title: string;

    /**
     * The relative path to the relevant attribute within the
     * associated resource(s). Only appropriate for problems that
     * apply to a single resource or type of resource
     */
    protected path: string;
}
